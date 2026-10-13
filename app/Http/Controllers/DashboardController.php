<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        $income = $user->transactions()
            ->where('type', 'income')
            ->sum('amount');

        $expenses = $user->transactions()
            ->where('type', 'expense')
            ->sum('amount');

        $balance = $income - $expenses;

        $recentTransactions = $user->transactions()
            ->with('category')
            ->orderByDesc('date')
            ->orderByDesc('id')
            ->limit(5)
            ->get();

        return view('dashboard', compact(
            'income',
            'expenses',
            'balance',
            'recentTransactions'
        ));
    }
}
