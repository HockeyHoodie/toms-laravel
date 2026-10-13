@extends('layouts.app')

@section('title', 'Edit category | Budgetly')

@section('content')
    <div class="page-heading">
        <div>
            <p class="eyebrow">ORGANIZATION</p>
            <h1>Edit category</h1>
            <p class="muted">Update the category's details.</p>
        </div>

        <a href="{{ route('categories.index') }}" class="btn btn-outline">
            ← Back to categories
        </a>
    </div>

    <section class="content-card form-card">
        <form action="{{ route('categories.update', $category) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name">Category name</label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name', $category->name) }}"
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
                    <option value="income"
                        @selected(old('type', $category->type) === 'income')>
                        Income
                    </option>

                    <option value="expense"
                        @selected(old('type', $category->type) === 'expense')>
                        Expense
                    </option>
                </select>

                @error('type')
                    <small class="field-error">{{ $message }}</small>
                @enderror

                @if ($category->transactions()->exists())
                    <small class="form-help">
                        This category already has transactions, so its type cannot be changed.
                    </small>
                @endif
            </div>

            <div class="form-actions">
                <a href="{{ route('categories.index') }}" class="btn btn-outline">
                    Cancel
                </a>

                <button type="submit" class="btn btn-primary">
                    Save changes
                </button>
            </div>
        </form>
    </section>
@endsection
