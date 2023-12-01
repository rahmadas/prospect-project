<?php

namespace App\Http\Controllers\AmountSent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AmountSentController extends Controller
{
    function amountSent()
    {
        $amountSents = DB::table('messages')
            ->select(DB::raw('status, count(*) as countAmountSent '))
            ->groupBy('status')
            ->get();

        $amountPending = $amountSents->where('status', 'pending')->sum('countAmountSent');
        $amountSuccess = $amountSents->where('status', 'success')->sum('countAmountSent');
        $amountFailed = $amountSents->where('status', 'failed')->sum('countAmountSent');
        // $amountInQueue = $amountSents->where('status', 'in_queue')->sum('countAmountSent');
        // $amountIsSending = $amountSents->where('status', 'is_sending')->sum('countAmountSent');

        $responseAmountSents = [
            'amount_pending' => $amountPending,
            'amount_success' => $amountSuccess,
            'amount_failed' => $amountFailed,
            // 'amount_inqueue' => $amountInQueue,
            // 'amount_issending' => $amountIsSending,
        ];

        return response()->json([
            'data' => $responseAmountSents,
            'message' => 'Successfully Count Amount Sent',
            'status' => true
        ]);
    }
}
