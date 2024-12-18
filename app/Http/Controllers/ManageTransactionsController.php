<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;

class ManageTransactionsController extends Controller
{
    public function view(Request $request)
    {
        $query = Transaction::query();

        if ($request->filled('from_date')) {
            $query->whereDate('payment_date', '>=', $request->from_date);
        }
        if ($request->filled('to_date')) {
            $query->whereDate('payment_date', '<=', $request->to_date);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('min_amount')) {
            $query->where('amount_paid', '>=', $request->min_amount);
        }
        if ($request->filled('max_amount')) {
            $query->where('amount_paid', '<=', $request->max_amount);
        }

        if ($request->filled('sort')) {
            if ($request->sort === 'oldest') {
                $query->orderBy('payment_date', 'asc');
            } elseif ($request->sort === 'newest') {
                $query->orderBy('payment_date', 'desc');
            }
        } else {
            $query->orderBy('payment_date', 'desc');
        }
        $transactions = $query->paginate(10);
        return view('transactions.view', compact('transactions'));
    }

    public function refund(Transaction $transaction)
    {
        if ($transaction->status === 'requesting refund') {
            $transaction->status = 'refunded';
            $transaction->save();

            return redirect()->route('transactions.view')->with('success', 'Transaction has been refunded.');
        }
        return redirect()->route('transactions.view')->with('error', 'Transaction cannot be refunded.');
    }

}
