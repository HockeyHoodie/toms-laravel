@extends('layouts.app')

@section('title', 'Edit transaction | Budgetly')

@section('content')
    <div class="page-heading">
        <div>
            <p class="eyebrow">FINANCIAL ACTIVITY</p>
            <h1>Edit transaction</h1>
            <p class="muted">Update the details of this transaction.</p>
        </div>

        <a href="{{ route('transactions.index') }}" class="btn btn-outline">
            ← Back to transactions
        </a>
    </div>

    <section class="content-card form-card">
        <form action="{{ route('transactions.update', $transaction) }}"
              method="POST">
            @csrf
            @method('PUT')

            @include('transactions._form', ['transaction' => $transaction])

            <div class="form-actions">
                <a href="{{ route('transactions.index') }}" class="btn btn-outline">
                    Cancel
                </a>

                <button type="submit" class="btn btn-primary">
                    Save changes
                </button>
            </div>
        </form>
    </section>
@endsection
