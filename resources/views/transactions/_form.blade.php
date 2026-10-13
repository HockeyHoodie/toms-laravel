<div class="form-group">
    <label for="title">Transaction title</label>

    <input
        type="text"
        id="title"
        name="title"
        value="{{ old('title', $transaction?->title ?? '') }}"
        placeholder="e.g. Weekly groceries"
        maxlength="255"
        required
        class="@error('title') input-error @enderror"
    >

    @error('title')
        <small class="field-error">{{ $message }}</small>
    @enderror
</div>

<div class="form-group">
    <label for="type">Transaction type</label>

    <select
        id="type"
        name="type"
        data-category-type-filter
        required
        class="@error('type') input-error @enderror"
    >
        <option value="income"
            @selected(old('type', $transaction?->type ?? 'expense') === 'income')>
            Income
        </option>

        <option value="expense"
            @selected(old('type', $transaction?->type ?? 'expense') === 'expense')>
            Expense
        </option>
    </select>

    @error('type')
        <small class="field-error">{{ $message }}</small>
    @enderror
</div>

<div class="form-group">
    <label for="category_id">Category</label>

    <select
        id="category_id"
        name="category_id"
        data-category-select
        required
        class="@error('category_id') input-error @enderror"
    >
        <option value="">Choose a category</option>

        @foreach ($categories as $category)
            <option
                value="{{ $category->id }}"
                data-type="{{ $category->type }}"
                @selected((string) old('category_id', $transaction?->category_id ?? '') === (string) $category->id)
            >
                {{ $category->name }}
            </option>
        @endforeach
    </select>

    @error('category_id')
        <small class="field-error">{{ $message }}</small>
    @enderror

    @if ($categories->isEmpty())
        <small class="form-help">
            You haven't created any categories yet.
            <a href="{{ route('categories.create') }}">Create one first</a>.
        </small>
    @endif
</div>

<div class="form-group">
    <label for="amount">Amount (€)</label>

    <input
        type="number"
        id="amount"
        name="amount"
        value="{{ old('amount', $transaction?->amount ?? '') }}"
        placeholder="0.00"
        min="0.01"
        step="0.01"
        required
        class="@error('amount') input-error @enderror"
    >

    @error('amount')
        <small class="field-error">{{ $message }}</small>
    @enderror
</div>

<div class="form-group">
    <label for="date">Transaction date</label>

    <input
        type="date"
        id="date"
        name="date"
        value="{{ old('date', $transaction?->date?->format('Y-m-d') ?? now()->format('Y-m-d')) }}"
        required
        class="@error('date') input-error @enderror"
    >

    @error('date')
        <small class="field-error">{{ $message }}</small>
    @enderror
</div>
