@extends('layouts.app')

@section('title', 'Transactions | Budgetly')

@section('content')
    <div class="page-heading">
        <div>
            <p class="eyebrow">FINANCIAL ACTIVITY</p>
            <h1>Transactions</h1>
            <p class="muted">Manage your income and expenses.</p>
        </div>

        <a href="{{ route('transactions.create') }}" class="btn btn-primary">
            + Add transaction
        </a>
    </div>

    <section class="content-card">
        <div class="section-heading">
            <div>
                <h2>All transactions</h2>
                <p class="muted">{{ $transactions->total() }} transactions found</p>
            </div>
        </div>

        <form action="{{ route('transactions.index') }}"
              method="GET"
              class="filter-form">

            <div class="filter-field">
                <label for="filter-type">Transaction type</label>

                <select id="filter-type" name="type">
                    <option value="">All types</option>

                    <option value="income" @selected(request('type') === 'income')>
                        Income
                    </option>

                    <option value="expense" @selected(request('type') === 'expense')>
                        Expense
                    </option>
                </select>
            </div>

            <div class="filter-field">
                <label for="filter-category">Category</label>

                <select id="filter-category" name="category_id">
                    <option value="">All categories</option>

                    @foreach ($categories as $category)
                        <option
                            value="{{ $category->id }}"
                            @selected((string) request('category_id') === (string) $category->id)
                        >
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">
                Apply filters
            </button>

            <a href="{{ route('transactions.index') }}" class="btn btn-outline">
                Clear
            </a>
        </form>

        @if ($transactions->isEmpty())
            <div class="empty-state">
                <div class="empty-icon">↗</div>
                <h3>No transactions found</h3>
                <p>Try changing your filters or create a new transaction.</p>

                <a href="{{ route('transactions.create') }}"
                   class="btn btn-primary">
                    Add transaction
                </a>
            </div>
        @else
            <div class="table-wrapper">
                <table id="transactions-table">
                    <thead>
                        <tr>
                            <th>Date</th>
                            <th>Transaction</th>
                            <th>Category</th>
                            <th>Type</th>
                            <th class="text-right">Amount</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($transactions as $transaction)
                            <tr data-transaction-row>
                                <td class="muted">
                                    {{ $transaction->date->format('d M Y') }}
                                </td>

                                <td>
                                    <strong>{{ $transaction->title }}</strong>
                                </td>

                                <td>
                                    <span class="category-badge">
                                        {{ $transaction->category->name }}
                                    </span>
                                </td>

                                <td>
                                    <span class="badge {{ $transaction->type === 'income' ? 'badge-income' : 'badge-expense' }}">
                                        {{ ucfirst($transaction->type) }}
                                    </span>
                                </td>

                                <td class="text-right">
                                    <span class="amount {{ $transaction->type === 'income' ? 'amount-income' : 'amount-expense' }}">
                                        {{ $transaction->type === 'income' ? '+' : '−' }}€{{ number_format($transaction->amount, 2) }}
                                    </span>
                                </td>

                                <td class="text-right">
                                    <div class="action-buttons">
                                        <a
                                            href="{{ route('transactions.edit', $transaction) }}"
                                            class="btn btn-outline btn-sm"
                                        >
                                            Edit
                                        </a>

                                        <form
                                            action="{{ route('transactions.destroy', $transaction) }}"
                                            method="POST"
                                            data-ajax-delete
                                        >
                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="btn btn-danger btn-sm">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="pagination-wrapper">
                {{ $transactions->links() }}
            </div>
        @endif
    </section>
@endsection
