<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = auth()->user()
            ->categories()
            ->withCount('transactions')
            ->orderBy('name')
            ->paginate(10);

        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        return view('categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories', 'name')
                    ->where('user_id', auth()->id()),
            ],
            'type' => 'required|in:income,expense',
        ]);

        auth()->user()->categories()->create($validated);

        return redirect()
            ->route('categories.index')
            ->with('success', 'Category created successfully.');
    }

    public function show(Category $category)
    {
        $this->authorizeOwnership($category);

        return redirect()->route('categories.edit', $category);
    }

    public function edit(Category $category)
    {
        $this->authorizeOwnership($category);

        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $this->authorizeOwnership($category);

        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories', 'name')
                    ->where('user_id', auth()->id())
                    ->ignore($category->id),
            ],
            'type' => 'required|in:income,expense',
        ]);

        if (
            $category->transactions()->exists()
            && $category->type !== $validated['type']
        ) {
            return back()
                ->withErrors([
                    'type' => 'You cannot change the type of a category that has transactions.',
                ])
                ->withInput();
        }

        $category->update($validated);

        return redirect()
            ->route('categories.index')
            ->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        $this->authorizeOwnership($category);

        if ($category->transactions()->exists()) {
            return back()->withErrors([
                'category' => 'This category cannot be deleted because it has transactions.',
            ]);
        }

        $category->delete();

        return redirect()
            ->route('categories.index')
            ->with('success', 'Category deleted successfully.');
    }

    private function authorizeOwnership(Category $category): void
    {
        abort_unless(
            (int) $category->user_id === (int) auth()->id(),
            404
        );
    }
}
