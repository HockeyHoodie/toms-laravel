<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class TransactionController extends Controller
{
    public function index(Request $request)
    {
        $user = $request->user();

        $filters = $request->validate([
            'type' => 'nullable|in:income,expense',
            'category_id' => [
                'nullable',
                'integer',
                Rule::exists('categories', 'id')
                    ->where('user_id', $user->id),
            ],
        ]);

        $query = $user->transactions()
            ->with('category');

        if (!empty($filters['type'])) {
            $query->where('type', $filters['type']);
        }

        if (!empty($filters['category_id'])) {
            $query->where('category_id', $filters['category_id']);
        }

        $transactions = $query
            ->orderByDesc('date')
            ->orderByDesc('id')
            ->paginate(10)
            ->withQueryString();

        $categories = $user->categories()
            ->orderBy('name')
            ->get();

        return view('transactions.index', compact(
            'transactions',
            'categories'
        ));
    }

    public function create()
    {
        $categories = auth()->user()
            ->categories()
            ->orderBy('name')
            ->get();

        return view('transactions.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $this->validateTransaction($request);

        $request->user()->transactions()->create($validated);

        return redirect()
            ->route('transactions.index')
            ->with('success', 'Transaction created successfully.');
    }

    public function show(Transaction $transaction)
    {
        $this->authorizeOwnership($transaction);

        return redirect()->route('transactions.edit', $transaction);
    }

    public function edit(Transaction $transaction)
    {
        $this->authorizeOwnership($transaction);

        $categories = auth()->user()
            ->categories()
            ->orderBy('name')
            ->get();

        return view('transactions.edit', compact(
            'transaction',
            'categories'
        ));
    }

    public function update(
        Request $request,
        Transaction $transaction
    ) {
        $this->authorizeOwnership($transaction);

        $validated = $this->validateTransaction($request);

        $transaction->update($validated);

        return redirect()
            ->route('transactions.index')
            ->with('success', 'Transaction updated successfully.');
    }

    public function destroy(
        Request $request,
        Transaction $transaction
    ) {
        $this->authorizeOwnership($transaction);

        $transaction->delete();

        if ($request->expectsJson()) {
            return response()->json([
                'message' => 'Transaction deleted successfully.',
                'id' => $transaction->id,
            ]);
        }

        return redirect()
            ->route('transactions.index')
            ->with('success', 'Transaction deleted successfully.');
    }

    private function validateTransaction(Request $request): array
    {
        $user = $request->user();

        return $request->validate([
            'title' => 'required|string|max:255',

            'amount' => [
                'required',
                'numeric',
                'gt:0',
                'decimal:0,2',
            ],

            'type' => 'required|in:income,expense',

            'category_id' => [
                'required',
                'integer',
                Rule::exists('categories', 'id')
                    ->where('user_id', $user->id)
                    ->where('type', $request->input('type')),
            ],

            'date' => 'required|date',
        ]);
    }

    private function authorizeOwnership(
        Transaction $transaction
    ): void {
        abort_unless(
            (int) $transaction->user_id === (int) auth()->id(),
            404
        );
    }
}
