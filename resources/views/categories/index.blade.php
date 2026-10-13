@extends('layouts.app')

@section('title', 'Categories | Budgetly')

@section('content')
    <div class="page-heading">
        <div>
            <p class="eyebrow">ORGANIZATION</p>
            <h1>Categories</h1>
            <p class="muted">Organize your income and expenses.</p>
        </div>

        <a href="{{ route('categories.create') }}" class="btn btn-primary">
            + Add category
        </a>
    </div>

    @if ($errors->has('category'))
        <div class="alert alert-error">
            {{ $errors->first('category') }}
        </div>
    @endif

    <section class="content-card">
        <div class="section-heading">
            <div>
                <h2>Your categories</h2>
                <p class="muted">{{ $categories->total() }} categories in total</p>
            </div>
        </div>

        @if ($categories->isEmpty())
            <div class="empty-state">
                <h3>No categories yet</h3>
                <p>Create a category to organize your transactions.</p>

                <a href="{{ route('categories.create') }}"
                   class="btn btn-primary">
                    Create category
                </a>
            </div>
        @else
            <div class="table-wrapper">
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Type</th>
                            <th>Transactions</th>
                            <th class="text-right">Actions</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($categories as $category)
                            <tr>
                                <td>
                                    <strong>{{ $category->name }}</strong>
                                </td>

                                <td>
                                    <span class="badge {{ $category->type === 'income' ? 'badge-income' : 'badge-expense' }}">
                                        {{ ucfirst($category->type) }}
                                    </span>
                                </td>

                                <td class="muted">
                                    {{ $category->transactions_count }}
                                </td>

                                <td class="text-right">
                                    <div class="action-buttons">
                                        <a href="{{ route('categories.edit', $category) }}"
                                           class="btn btn-outline btn-sm">
                                            Edit
                                        </a>

                                        <form
                                            action="{{ route('categories.destroy', $category) }}"
                                            method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this category?')"
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
                {{ $categories->links() }}
            </div>
        @endif
    </section>
@endsection
