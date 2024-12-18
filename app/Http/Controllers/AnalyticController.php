<?php

namespace App\Http\Controllers;
use App\Models\Transaction;
use Illuminate\Http\Request;

class AnalyticController extends Controller
{
    public function view()
    {
        $totalSales = Transaction::sum('amount_paid');
        $totalCustomers = Transaction::distinct('user_id')->count('user_id');
        $averageOrderValue = Transaction::avg('amount_paid');
        return view('analytics.view', compact('totalSales', 'totalCustomers', 'averageOrderValue'));
    }
}
