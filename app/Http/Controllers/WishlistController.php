<?php

namespace App\Http\Controllers;

use App\Models\Wishlist;
use App\Models\Work;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class WishlistController extends Controller
{
    public function index(Request $request)
    {
        $items = Wishlist::query()
            ->forCurrent()
            ->with(['work' => function ($q) {
                $q->withMin('variants', 'price');
            }])
            ->latest()
            ->get();

        return view('frontend.wishlist.wishlist', compact('items'));
    }

    public function add(Request $request)
    {
        $data = $request->validate([
            'work_id' => ['required','integer','exists:works,id'],
        ]);

        $userId = $request->user()?->id;
        $sid    = $request->session()->getId();
        $workId = $data['work_id'];

        try {
            DB::transaction(function () use ($userId, $sid, $workId) {
                $exists = Wishlist::query()
                    ->when($userId,
                        fn($q) => $q->where('user_id', $userId),
                        fn($q) => $q->whereNull('user_id')->where('session_id', $sid)
                    )
                    ->where('work_id', $workId)
                    ->lockForUpdate()
                    ->first();

                if (!$exists) {
                    Wishlist::create([
                        'user_id'    => $userId,
                        'session_id' => $sid,
                        'work_id'    => $workId,
                    ]);
                }
            });
        } catch (\Throwable $e) {
            return response()->json([
                'status'  => 'error',
                'message' => 'Unable to add to wishlist.',
            ], 500);
        }

        return response()->json([
            'status' => 'success',
            'message'=> 'Added to wishlist',
            'count'  => Wishlist::countForCurrent(),
        ]);
    }

    public function remove(Request $request, Wishlist $wishlist)
    {
        $userId = $request->user()->id ?? null;
        $sid    = $request->session()->getId();

        $isOwner = ($userId && $wishlist->user_id === $userId)
            || (is_null($wishlist->user_id) && $wishlist->session_id === $sid);

        if (!$isOwner) {
            return response()->json(['status'=>'error','message'=>'Not allowed'], 403);
        }

        $wishlist->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Removed from wishlist',
            'count'   => Wishlist::countForCurrent(),
        ]);
    }

    public function removePage(Request $request, Work $work)
    {
        $userId = $request->user()->id ?? null;
        $sid    = $request->session()->getId();

        $wishlist = Wishlist::query()
            ->when($userId, fn($q) => $q->where('user_id', $userId))
            ->when(is_null($userId), fn($q) => $q->where('session_id', $sid))
            ->where('work_id', $work->id)
            ->first();

        if (!$wishlist) {
            return response()->json(['status'=>'error','message'=>'Not found'], 404);
        }

        $wishlist->delete();

        return response()->json([
            'status'  => 'success',
            'message' => 'Removed from wishlist',
            'count'   => Wishlist::countForCurrent(),
        ]);
    }

    /**
     * Optional helper if you want to call this on login/register.
     * Merges guest wishlist (old session) into logged-in wishlist.
     */
    public static function mergeGuestToUser(string $oldSessionId, int $userId): void
    {
        DB::transaction(function () use ($oldSessionId, $userId) {
            $guestRows = Wishlist::whereNull('user_id')
                ->where('session_id', $oldSessionId)
                ->lockForUpdate()
                ->get();

            foreach ($guestRows as $g) {
                $dupe = Wishlist::where('user_id', $userId)
                    ->where('work_id', $g->work_id)
                    ->first();

                if ($dupe) {
                    $g->delete();
                } else {
                    $g->user_id = $userId;
                    $g->save();
                }
            }
        });
    }
}