<?php

namespace App\Services;

use App\Models\TempCart;
use Illuminate\Support\Facades\DB;

class CartMergeService
{
    /**
     * Merge all guest cart lines from $oldSid into the authenticated user's cart.
     */
    public function merge(string $oldSid, int $userId, string $newSid): void
    {
        if (!$oldSid || !$userId) return;

        DB::transaction(function () use ($oldSid, $userId, $newSid) {
            $guestLines = TempCart::whereNull('user_id')
                ->where('session_id', $oldSid)
                ->lockForUpdate()
                ->get();

            foreach ($guestLines as $line) {
                // same product + same variant => increment
                $existing = TempCart::where('user_id', $userId)
                    ->where('work_id', $line->work_id)
                    ->where('work_variant_id', $line->work_variant_id)
                    ->lockForUpdate()
                    ->first();

                if ($existing) {
                    $existing->quantity = min($existing->quantity + $line->quantity, 999);
                    // carry over latest price/label if you want
                    $existing->unit_price   = $line->unit_price;
                    $existing->variant_text = $line->variant_text;
                    $existing->save();
                    $line->delete();
                } else {
                    // move guest row under the user and the new session id
                    $line->user_id    = $userId;
                    $line->session_id = $newSid;
                    $line->save();
                }
            }
        });
    }
}
