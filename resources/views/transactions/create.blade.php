@extends('layouts.app')

@section('title', 'Add transaction | Budgetly')

@section('content')
    <div class="page-heading">
        <div>
            <p class="eyebrow">FINANCIAL ACTIVITY</p>
            <h1>Add transaction</h1>
            <p class="muted">Record new income or an expense.</p>
        </div>

        <a href="{{ route('transactions.index') }}" class="btn btn-outline">
            ← Back to transactions
        </a>
    </div>

    <section class="content-card form-card">
        @if ($categories->isEmpty())
            <div class="alert alert-error">
                You must create at least one category before adding a transaction.
                <a href="{{ route('categories.create') }}">Create a category</a>.
            </div>
        @endif

        <form action="{{ route('transactions.store') }}" method="POST">
            @csrf

            @include('transactions._form', ['transaction' => null])

            <div class="form-actions">
                <a href="{{ route('transactions.index') }}" class="btn btn-outline">
                    Cancel
                </a>

                <button
                    type="submit"
                    class="btn btn-primary"
                    @disabled($categories->isEmpty())
                >
                    Save transaction
                </button>
            </div>
        </form>
    </section>
@endsection
