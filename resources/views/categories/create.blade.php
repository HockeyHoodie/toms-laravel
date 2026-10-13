@extends('layouts.app')

@section('title', 'Create category | Budgetly')

@section('content')
    <div class="page-heading">
        <div>
            <p class="eyebrow">ORGANIZATION</p>
            <h1>Create category</h1>
            <p class="muted">Add a category for your transactions.</p>
        </div>

        <a href="{{ route('categories.index') }}" class="btn btn-outline">
            ← Back to categories
        </a>
    </div>

    <section class="content-card form-card">
        <form action="{{ route('categories.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="name">Category name</label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="e.g. Groceries"
                    maxlength="255"
                    required
                    autofocus
                    class="@error('name') input-error @enderror"
                >

                @error('name')
                    <small class="field-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="type">Category type</label>

                <select
                    id="type"
                    name="type"
                    required
                    class="@error('type') input-error @enderror"
                >
                    <option value="">Choose a type</option>

                    <option value="income" @selected(old('type') === 'income')>
                        Income
                    </option>

                    <option value="expense" @selected(old('type', 'expense') === 'expense')>
                        Expense
                    </option>
                </select>

                @error('type')
                    <small class="field-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-actions">
                <a href="{{ route('categories.index') }}" class="btn btn-outline">
                    Cancel
                </a>

                <button type="submit" class="btn btn-primary">
                    Create category
                </button>
            </div>
        </form>
    </section>
@endsection
