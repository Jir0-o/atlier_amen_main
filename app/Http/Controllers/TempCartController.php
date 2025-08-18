<?php

namespace App\Http\Controllers;

use App\Models\TempCart;
use App\Models\Work;
use App\Models\WorkVariant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class TempCartController extends Controller
{
    public function add(Request $request)
    {
        $data = $request->validate([
            'work_id'    => ['required','integer','exists:works,id'],
            'variant_id' => ['nullable','integer'],
            // If you prefer resolving on server from value_ids:
            'value_ids'  => ['sometimes','array'],
            'value_ids.*'=> ['integer'],
            'qty'        => ['nullable','integer','min:1'],
        ]);

        $qty  = $data['qty'] ?? 1;
        $work = Work::findOrFail($data['work_id']);

        // Resolve variant
        $variant = null;

        if (!empty($data['variant_id'])) {
            $variant = WorkVariant::where('id', $data['variant_id'])
                ->where('work_id', $work->id)
                ->first();
            if (!$variant) {
                return response()->json(['status'=>'error','message'=>'Invalid variant selected.'], 422);
            }
        } elseif (!empty($data['value_ids'])) {
            // Optional: resolve by attribute value IDs
            $resolvedId = $this->resolveVariantIdFromValueIds($work->id, (array)$data['value_ids']);
            if ($resolvedId) {
                $variant = WorkVariant::find($resolvedId);
            } elseif ($work->variants()->exists()) {
                return response()->json(['status'=>'error','message'=>'Variant not found for selected options.'], 422);
            }
        } else {
            // product has variants but none provided
            if ($work->variants()->exists()) {
                return response()->json(['status'=>'error','message'=>'Please select options.'], 422);
            }
        }

        // Optional stock check
        if ($variant && !is_null($variant->stock) && $variant->stock < 1) {
            return response()->json(['status'=>'error','message'=>'Selected variant is out of stock.'], 422);
        }

        $price      = $variant?->price ?? $work->price ?? 0;
        $sessionId  = $request->session()->getId();
        $userId     = Auth::id();
        $variantTxt = $variant ? $variant->combinationText() : null;
        $lineId = null;

        DB::transaction(function () use ($sessionId, $userId, $work, $variant, $price, $qty, $variantTxt, &$lineId) {
            $existing = TempCart::query()
                ->when($userId,
                    fn($q) => $q->where('user_id', $userId),
                    fn($q) => $q->whereNull('user_id')->where('session_id', $sessionId)
                )
                ->where('work_id', $work->id)
                ->where('work_variant_id', $variant?->id)
                ->lockForUpdate()
                ->first();

            if ($existing) {
                $existing->increment('quantity', $qty);
                $existing->update(['unit_price' => $price, 'variant_text' => $variantTxt]);
                $lineId = $existing->id;
            } else {
                $created = TempCart::create([
                    'user_id'         => $userId,
                    'session_id'      => $sessionId,
                    'work_id'         => $work->id,
                    'work_variant_id' => $variant?->id,
                    'unit_price'      => $price,
                    'quantity'        => $qty,
                    'work_name'       => $work->name,
                    'work_image_low'  => $work->work_image_low_url,
                    'variant_text'    => $variantTxt,
                ]);
                $lineId = $created->id;
            }
        });

        $cartCount = (int) TempCart::where('session_id', $sessionId)
            ->when($userId, fn($q)=>$q->orWhere('user_id',$userId))
            ->sum('quantity');

        return response()->json([
            'status'     => 'success',
            'message'    => 'Added to cart',
            'cart_count' => $cartCount,
            'line_id'    => $lineId,
        ]);
    }

    public function buyNow(Request $request)
    {
        // Re-use add() so we validate + upsert the line
        $resp = $this->add($request);
        $data = $resp->getData(true);

        if (($data['status'] ?? null) !== 'success') {
            return $resp;
        }

        $lineId = $data['line_id'] ?? null;
        $qty    = (int)($request->input('qty') ?? 1);

        return response()->json([
            'status'   => 'success',
            'redirect' => $lineId
                ? route('checkout.form', ['cart_line_id' => $lineId, 'buy_qty' => $qty])
                : route('checkout.form'),
        ]);
    }

 

    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $user    = $request->user();
            $session = $request->session()->getId();

            $lines = TempCart::with([
                    'work:id,name,work_image,is_active,price,quantity',
                    'workVariant:id,work_id,sku,stock',
                    'workVariant.attributeValues.attribute'
                ])
                ->where(function($q) use ($user, $session) {
                    if ($user) $q->where('user_id', $user->id);
                    else $q->whereNull('user_id')->where('session_id', $session);
                })
                ->latest()->get();

            $hold   = [];
            $out    = [];

            foreach ($lines as $line) {
                $work   = $line->work;
                $variant= $line->workVariant;

                // Inactive work => out
                if (!$work || (int)$work->is_active !== 1) {
                    $line->reason = 'inactive';
                    $out[] = $this->mapCartLine($line);
                    continue;
                }

                $available = null; 
                if ($variant) {
                    $available = $variant->stock; 
                } else {
                    $available = $work->quantity; 
                }

                // Partition
                if (!is_null($available) && (int)$available <= 0) {
                    $line->reason = 'out_of_stock';
                    $out[] = $this->mapCartLine($line, $available);
                } elseif (!is_null($available) && (int)$line->quantity > (int)$available) {
                    $line->reason = 'insufficient';
                    $out[] = $this->mapCartLine($line, $available);
                } else {
                    $hold[] = $this->mapCartLine($line, $available);
                }
            }

            // Totals only from HELD items
            $subtotal = collect($hold)->sum(fn($it) => ($it['unit_price'] ?? 0) * ($it['quantity'] ?? 0));
            $shipping = 10.00;
            $grand    = $subtotal + $shipping;
            $count    = collect($hold)->sum('quantity');

            return response()->json([
                'hold_items'     => $hold,
                'stockout_items' => $out,
                'summary' => [
                    'count'    => $count,
                    'subtotal' => $subtotal,
                    'shipping' => $shipping,
                    'grand'    => $grand,
                ],
            ]);
        }

        // HTML page render
        $featuredWorks = Work::active()->where('is_featured',1)->latest()->take(8)->get();
        return view('frontend.cart.index', compact('featuredWorks'));
    }

    protected function mapCartLine($line, $available = null): array
    {
        $work   = $line->work;
        $variant= $line->workVariant;

        $variantText = $line->variant_text; 
        if (!$variantText && $variant && $variant->relationLoaded('attributeValues')) {
            $groups = [];
            foreach ($variant->attributeValues as $av) {
                $attr = $av->attribute->name ?? 'Option';
                $groups[$attr][] = $av->value;
            }
            $parts = [];
            foreach ($groups as $a => $vals) $parts[] = $a . ': ' . implode(', ', $vals);
            $variantText = implode(' / ', $parts);
        }

        return [
            'id'           => $line->id,
            'work_id'      => $line->work_id,
            'work_name'    => $work?->name,
            'work_image'   => $work?->work_image,     
            'work_active'  => (bool)($work?->is_active),
            'work_type'    => $work?->work_type,
            'work_variant' => $variant?->toArray(),
            'variant_text' => $variantText,
            'unit_price'   => $line->unit_price ?? ($work?->price ?? 0),
            'quantity'     => (int)$line->quantity,
            'available'    => is_null($available) ? null : (int)$available,
            'reason'       => $line->reason ?? null,
        ];
    }


    public function count(Request $request)
    {
        $cartCount = $this->currentCartCount(auth()->id(), $request->session()->getId());
        session(['cart_count' => $cartCount]);
        return response()->json(['cart_count' => $cartCount]);
    }

    public function updateQuantity(Request $request, TempCart $tempCart)
    {
        $validated = $request->validate([
            'quantity' => ['required','integer','min:1','max:999'],
        ]);
        if (!$this->ownsCartLine($tempCart, $request)) abort(403);

        $tempCart->quantity = $validated['quantity'];
        $tempCart->save();

        $cartCount = $this->currentCartCount(auth()->id(), $request->session()->getId());
        session(['cart_count' => $cartCount]);

        return response()->json([
            'status'     => 'success',
            'message'    => 'Quantity updated',
            'quantity'   => $tempCart->quantity,
            'cart_count' => $cartCount,
        ]);
    }

    public function destroy(Request $request, TempCart $tempCart)
    {
        if (!$this->ownsCartLine($tempCart, $request)) abort(403);

        $tempCart->delete();

        $cartCount = $this->currentCartCount(auth()->id(), $request->session()->getId());
        session(['cart_count' => $cartCount]);

        return response()->json([
            'status'     => 'success',
            'message'    => 'Item removed',
            'cart_count' => $cartCount,
        ]);
    }

    public function clear(Request $request)
    {
        [$userId, $session] = [auth()->id(), $request->session()->getId()];

        TempCart::where(function ($q) use ($userId, $session) {
            if ($userId) $q->where('user_id', $userId);
            else $q->whereNull('user_id')->where('session_id', $session);
        })->delete();

        session(['cart_count' => 0]);

        return response()->json(['status'=>'success','message'=>'Cart cleared']);
    }

    public function mergeGuestCartToUser(Request $request)
    {
        $userId = auth()->id();
        if (!$userId) return response()->json(['message'=>'Not logged in'],401);
        $session = $request->session()->getId();

        DB::transaction(function() use($userId, $session) {
            $guestLines = TempCart::whereNull('user_id')->where('session_id', $session)
                ->lockForUpdate()->get();

            foreach ($guestLines as $line) {
                $existing = TempCart::where('user_id',$userId)
                    ->where('work_id',$line->work_id)
                    ->where('work_variant_id',$line->work_variant_id) // variant-aware
                    ->lockForUpdate()
                    ->first();

                if ($existing) {
                    $existing->quantity = min($existing->quantity + $line->quantity, 999);
                    $existing->unit_price = $line->unit_price;
                    $existing->variant_text = $line->variant_text;
                    $existing->save();
                    $line->delete();
                } else {
                    $line->user_id = $userId;
                    $line->save();
                }
            }
        });

        return response()->json(['message'=>'Guest cart merged.']);
    }

    public function syncGuestCartStorage(Request $request)
    {
        $userId = auth()->id();
        if (!$userId) return response()->json(['message'=>'Not logged in'],401);

        // Expect: items: [{work_id, variant_id, qty}]
        $items   = $request->input('items', []);
        $session = $request->session()->getId();

        DB::transaction(function() use($items, $userId, $session) {
            foreach ($items as $it) {
                $workId    = (int)($it['work_id'] ?? 0);
                $variantId = isset($it['variant_id']) ? (int)$it['variant_id'] : null;
                $qty       = (int)($it['qty'] ?? 0);
                if ($workId < 1 || $qty < 1) continue;

                $existing = TempCart::where('user_id', $userId)
                    ->where('work_id', $workId)
                    ->where('work_variant_id', $variantId)
                    ->lockForUpdate()
                    ->first();

                if ($existing) {
                    $existing->quantity = min($existing->quantity + $qty, 999);
                    $existing->save();
                } else {
                    if ($work = Work::find($workId)) {
                        $variant = $variantId
                            ? WorkVariant::where('id',$variantId)->where('work_id',$workId)->first()
                            : null;
                        TempCart::create([
                            'user_id'         => $userId,
                            'session_id'      => $session,
                            'work_id'         => $workId,
                            'work_variant_id' => $variant?->id,
                            'unit_price'      => $variant?->price ?? $work->price ?? 0,
                            'quantity'        => $qty,
                            'work_name'       => $work->name,
                            'work_image_low'  => $work->work_image_low_url,
                            'variant_text'    => $variant?->combinationText(),
                        ]);
                    }
                }
            }
        });

        $count = $this->currentCartCount($userId, $session);
        session(['cart_count' => $count]);

        return response()->json(['message'=>'Guest cart synced.','cart_count'=>$count]);
    }

    protected function ownsCartLine(TempCart $line, Request $request): bool
    {
        $userId  = auth()->id();
        $session = $request->session()->getId();

        return ($userId && $line->user_id === $userId)
            || (!$userId && is_null($line->user_id) && $line->session_id === $session);
    }

    protected function currentCartCount(?int $userId, string $session): int
    {
        return (int) TempCart::where(function ($q) use ($userId, $session) {
            if ($userId) $q->where('user_id', $userId);
            else $q->whereNull('user_id')->where('session_id', $session);
        })->sum('quantity');
    }

    // Optional: Resolve variant from attribute value IDs (exact match)
    protected function resolveVariantIdFromValueIds(int $workId, array $valueIds): ?int
    {
        $valueIds = array_values(array_unique(array_map('intval', $valueIds)));
        if (empty($valueIds)) return null;

        $count = count($valueIds);

        // Candidate variants that contain all the given values
        $candidateIds = DB::table('work_variant_attribute_value as wvav')
            ->join('work_variants as wv', 'wv.id', '=', 'wvav.work_variant_id')
            ->where('wv.work_id', $workId)
            ->whereIn('wvav.attribute_value_id', $valueIds)
            ->groupBy('wvav.work_variant_id')
            ->havingRaw('COUNT(*) = ?', [$count])
            ->pluck('wvav.work_variant_id');

        if ($candidateIds->isEmpty()) return null;

        // Ensure no extra values (exact match)
        $exact = WorkVariant::whereIn('id', $candidateIds)
            ->withCount('attributeValues')
            ->get()
            ->firstWhere('attribute_values_count', $count);

        return $exact?->id;
    }
}