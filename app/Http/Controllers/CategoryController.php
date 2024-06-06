<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Requests\CategoryRequest;
use App\Models\User;
use App\Models\CustomCategory;
use App\Http\Requests\CustomCategoryRequest;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('settings.categories.index', ['categories' => Category::all(), 'custom_categories' => CustomCategory::all()]);
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
    
        // Check if a category was found
        if (!$category) {
            // Handle the case where no category is found, e.g., redirect to a 404 page or show an error message
            abort(404, "Category not found");
        }
    
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
    public function update(Request $request, CustomCategory $custom_category)
    {
    // Validate the incoming request data. Adjust the rules according to your needs.
    $validatedData = $request->validate([
        // Validation rules for updating a CustomCategory
        'displayname' => 'required',
        'color' => 'nullable|string',
        'icon' => 'nullable|string',
        'user_id' => 1,
        // Add other fields as necessary
    ]);

    // Attempt to update the CustomCategory with the validated data
    $isUpdated = $custom_category->update($validatedData);

    // Check if the update was successful
    if ($isUpdated) {
        // Redirect to the show page for the updated CustomCategory
        // Note: Using displayname in the route parameter is unconventional and may require adjustments
        return redirect()->route('categories.show', ['custom_category' => $custom_category->displayname])
            ->with('success', 'Custom category updated successfully');
    } else {
        // Handle the case where the update failed
        // This could involve returning an error response or redirecting back with errors
        return back()->withErrors(['custom_category' => 'Failed to update the custom category.']);
    }
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
