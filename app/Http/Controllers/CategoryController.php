<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\Budget;
use App\Http\Requests\CategoryRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user_id = auth()->id();
        $categories = Category::where('user_id', $user_id)->get();
        $incomeCategories = $categories->where('is_income', true);
        $expenseCategories = $categories->where('is_income', false);

        return view('settings.categories.index', compact('incomeCategories', 'expenseCategories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('settings.categories.form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        $validated = $request->validated();
        $validated['user_id'] = auth()->id();
        $category = Category::create($validated);

        return redirect()->route('categories.index')->with('success', 'Category created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $category = Category::findOrFail($id);
        $categories = Category::where('id', '!=', $category->id)->get(); // Fetch other categories for the dropdown

        return view('settings.categories.show', [
            'category' => $category,
            'categories' => $categories,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('settings.categories.form', ['category' => $category]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $category->update($request->validated());

        return redirect()->route('categories.show', ['category' => $category->id])
            ->with('success', 'Category updated successfully');
    }

    /**
     * Toggle the visibility of the specified resource.
     */
    public function toggle(Category $category)
    {
        $category->toggleShow();

        return redirect()->back()->with('success', 'Category updated successfully');
    }
}
