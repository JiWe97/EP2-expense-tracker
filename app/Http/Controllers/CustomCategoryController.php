<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\CustomCategory;
use App\Http\Requests\CustomCategoryRequest;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class CustomCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('settings.custom_categories.index', ['custom_categories' => CustomCategory::all(), 'categories' => Category::all()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        \Log::info('Creating custom category with data:', $customCategoryData);

        return view('settings.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'custom_category.*.displayname' => 'nullable|string|max:255',
            'custom_category.*.category_id' => 'required|integer|exists:categories,id',
        ]);

        foreach ($validatedData['custom_category'] as $id => $customCategoryData) {
            $customCategoryData['user_id'] = Auth::user()->id; // Use authenticated user's ID
            $customCategoryData['displayname'] = $customCategoryData['displayname'] ?? ''; // Ensure displayname is not null
            

            if (strpos($id, 'new_') !== false) {
                // Create new custom category
                CustomCategory::create($customCategoryData);
            } else {
                // Update existing custom category
                $customCategory = CustomCategory::find($id);
                if ($customCategory) {
                    $customCategory->update($customCategoryData);
                }
            }
        }

        return redirect()->back()->with('success', 'Categories saved successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show($custom_categoryId)
    {
        $custom_category = CustomCategory::where('displayname', $custom_categoryId)->first();
        return view('settings.custom_categories.show', ['custom_category' => $custom_category]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('settings.custom_categories.edit', ['custom_category' => $custom_category]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'custom_category.*.displayname' => 'nullable|string|max:255',
            'custom_category.*.category_id' => 'required|integer|exists:categories,id',
        ]);

        foreach ($validatedData['custom_category'] as $id => $customCategoryData) {
            $customCategory = CustomCategory::find($id);
            if ($customCategory) {
                $customCategoryData['user_id'] = Auth::user()->id; // Use authenticated user's ID
                $customCategoryData['displayname'] = $customCategoryData['displayname'] ?? ''; // Ensure displayname is not null
                $customCategory->update($customCategoryData);
            }
        }

        return redirect()->back()->with('success', 'Categories updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CustomCategory $custom_category)
    {
        $custom_category->delete();
        return redirect()->route('custom_categories.index')
            ->with('success', 'category deleted successfully');
    }
}
