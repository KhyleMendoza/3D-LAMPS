<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;

class TransactionController extends Controller
{
    public function view()
    {
        $transactions = Transaction::where('user_id', auth()->id())
            ->latest()
            ->get();

        return view('transaction.view', compact('transactions'));
    }

    public function requestRefund(Transaction $transaction)
    {
        if ($transaction->user_id !== auth()->id()) {
            return redirect()->route('transaction.view')->with('error', 'You do not have permission to refund this transaction.');
        }
        $transaction->status = 'requesting refund';
        $transaction->save();
        return redirect()->route('transaction.view')->with('success', 'Refund request has been made.');
    }
}
