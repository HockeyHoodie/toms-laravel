@extends('layouts.app')

@section('title', 'Dashboard | Budgetly')

@section('content')
    <div class="page-heading">
        <div>
            <p class="eyebrow">OVERVIEW</p>
            <h1>Welcome back, {{ auth()->user()->name }}!</h1>
            <p class="muted">Here's what's happening with your money.</p>
        </div>

        <a href="{{ route('transactions.create') }}" class="btn btn-primary">
            + Add transaction
        </a>
    </div>

    <div class="stats-grid">
        <article class="stat-card">
            <div class="stat-label">
                <span class="stat-icon income-icon">↗</span>
                Total income
            </div>

            <div class="stat-value">
                €{{ number_format($income, 2) }}
            </div>

            <p class="stat-description">All recorded income</p>
        </article>

        <article class="stat-card">
            <div class="stat-label">
                <span class="stat-icon expense-icon">↘</span>
                Total expenses
            </div>

            <div class="stat-value">
                €{{ number_format($expenses, 2) }}
            </div>

            <p class="stat-description">All recorded expenses</p>
        </article>

        <article class="stat-card">
            <div class="stat-label">
                <span class="stat-icon balance-icon">€</span>
                Remaining balance
            </div>

            <div class="stat-value {{ $balance < 0 ? 'text-danger' : 'text-success' }}">
                €{{ number_format($balance, 2) }}
            </div>

            <p class="stat-description">Income minus expenses</p>
        </article>
    </div>

    <section class="content-card">
        <div class="section-heading">
            <div>
                <h2>Recent transactions</h2>
                <p class="muted">Your latest financial activity.</p>
            </div>

            <a href="{{ route('transactions.index') }}" class="text-link">
                View all →
            </a>
        </div>

        @if ($recentTransactions->isEmpty())
            <div class="empty-state">
                <div class="empty-icon">↗</div>
                <h3>No transactions yet</h3>
                <p>Add your first income or expense to get started.</p>

                <a href="{{ route('transactions.create') }}"
                   class="btn btn-primary">
                    Add your first transaction
                </a>
            </div>
        @else
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Transaction</th>
                            <th>Category</th>
                            <th>Date</th>
                            <th class="text-right">Amount</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($recentTransactions as $transaction)
                            <tr>
                                <td>
                                    <div class="transaction-title">
                                        {{ $transaction->title }}
                                    </div>
                                </td>

                                <td>
                                    <span class="category-badge">
                                        {{ $transaction->category->name }}
                                    </span>
                                </td>

                                <td class="muted">
                                    {{ $transaction->date->format('d M Y') }}
                                </td>

                                <td class="text-right">
                                    <span class="amount {{ $transaction->type === 'income' ? 'amount-income' : 'amount-expense' }}">
                                        {{ $transaction->type === 'income' ? '+' : '−' }}€{{ number_format($transaction->amount, 2) }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </section>
@endsection
