<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Requests\CategoryRequest;
use App\Models\User;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('settings.categories.index', ['categories' => Category::all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        return view('settings.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        $category = Category::create($request->validated());
        return redirect()->route('categories.index', ['category' => $category->id])
            ->with('success', 'Category created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show($categoryId)
    {
        $category = Category::where('name', $categoryId)->first();
        return view('settings.categories.show', ['category' => $category]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('settings.categories.edit', ['category' => $category]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $category->update($request->validated());
        return redirect()->route('categories.show', ['category' => $category->name])
            ->with('success', 'category updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {    
        $category->delete();
        return redirect()->route('categories.index')
            ->with('success', 'category deleted successfully');
    }

    public function toggle(Category $category)
    {
        $category->toggleShow();
        return redirect()->back()->with('success', 'Category updated successfully');
    }
}
