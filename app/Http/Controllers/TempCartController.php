<?php

namespace App\Http\Controllers;

use App\Models\TempCart;
use App\Models\Work;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TempCartController extends Controller
{
    public function add(Request $request)
    {
        $validated = $request->validate([
            'work_id' => 'required|exists:works,id',
            'qty'     => 'nullable|integer|min:1|max:50',
        ]);

        $qty     = $validated['qty'] ?? 1;
        $workId  = (int) $validated['work_id'];
        $userId  = auth()->id();
        $session = $request->session()->getId();

        $work = Work::findOrFail($workId);

        DB::beginTransaction();
        try {
            $query = TempCart::where('work_id', $workId)
                ->where(function($q) use($userId, $session) {
                    if ($userId) {
                        $q->where('user_id', $userId);
                    } else {
                        $q->whereNull('user_id')->where('session_id', $session);
                    }
                })->lockForUpdate();

            if ($item = $query->first()) {
                $item->quantity = min($item->quantity + $qty, 999);
                $item->save();
            } else {
                $item = TempCart::create([
                    'user_id'        => $userId,
                    'session_id'     => $session,
                    'work_id'        => $workId,
                    'quantity'       => $qty,
                    'work_name'      => $work->name,
                    'work_image_low' => $work->work_image_low ?? $work->work_image_low_url,
                ]);
            }

            $count = $this->currentCartCount($userId, $session);
            session(['cart_count' => $count]);

            DB::commit();

            return response()->json([
                'status'     => 'success',
                'message'    => 'Added to cart',
                'cart_count' => $count,
                'item_id'    => $item->id,
                'quantity'   => $item->quantity,
            ]);
        } catch (\Throwable $e) {
            DB::rollBack();
            report($e);
            return response()->json(['status'=>'error','message'=>'Failed to add'],500);
        }
    }

    public function index(Request $request)
    {
        [$userId, $session] = [$request->user()?->id, $request->session()->getId()];

        $items = TempCart::with('work')
            ->where(function ($q) use ($userId, $session) {
                if ($userId) {
                    $q->where('user_id', $userId);
                } else {
                    $q->whereNull('user_id')->where('session_id', $session);
                }
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json([
            'items'      => $items,
            'cart_count' => $items->sum('quantity'),
        ]);
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
            'quantity' => ['required', 'integer', 'min:1', 'max:999'],
        ]);

        if (!$this->ownsCartLine($tempCart, $request)) {
            abort(403);
        }

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
        if (!$this->ownsCartLine($tempCart, $request)) {
            abort(403);
        }

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
            if ($userId) {
                $q->where('user_id', $userId);
            } else {
                $q->whereNull('user_id')->where('session_id', $session);
            }
        })->delete();

        session(['cart_count' => 0]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Cart cleared',
        ]);
    }

    public function mergeGuestCartToUser(Request $request)
    {
        $userId = auth()->id();
        if (! $userId) {
            return response()->json(['message'=>'Not logged in'],401);
        }
        $session = $request->session()->getId();

        DB::transaction(function() use($userId, $session) {
            $guestLines = TempCart::whereNull('user_id')
                ->where('session_id', $session)
                ->lockForUpdate()
                ->get();

            foreach ($guestLines as $line) {
                $existing = TempCart::where('user_id',$userId)
                    ->where('work_id',$line->work_id)
                    ->lockForUpdate()
                    ->first();

                if ($existing) {
                    $existing->quantity = min($existing->quantity + $line->quantity,999);
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
        if (! $userId) {
            return response()->json(['message'=>'Not logged in'],401);
        }

        $items   = $request->input('items', []);
        $session = $request->session()->getId();

        DB::transaction(function() use($items, $userId, $session) {
            foreach ($items as $workId => $qty) {
                if (! is_numeric($qty) || $qty < 1) continue;

                $existing = TempCart::where('user_id', $userId)
                    ->where('work_id', $workId)
                    ->lockForUpdate()
                    ->first();

                if ($existing) {
                    $existing->quantity = min($existing->quantity + $qty, 999);
                    $existing->save();
                } else {
                    if ($work = Work::find($workId)) {
                        TempCart::create([
                            'user_id'        => $userId,
                            'session_id'     => $session,
                            'work_id'        => $workId,
                            'quantity'       => $qty,
                            'work_name'      => $work->name,
                            'work_image_low' => $work->work_image_low ?? $work->work_image_low_url,
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
        return TempCart::where(function ($q) use ($userId, $session) {
            if ($userId) {
                $q->where('user_id', $userId);
            } else {
                $q->whereNull('user_id')->where('session_id', $session);
            }
        })->sum('quantity');
    }
}
