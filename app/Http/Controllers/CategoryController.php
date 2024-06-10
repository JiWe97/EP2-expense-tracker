<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Http\Requests\CategoryRequest;
use App\Models\User;
use App\Models\CustomCategory;
use App\Http\Requests\CustomCategoryRequest;
use Illuminate\Support\Facades\Auth;

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
    public function store(CustomCategoryRequest $request)
    {
        $validatedData = $request->validate([
            'custom_category.*.displayname' => 'nullable|string|max:255',
            'custom_category.*.category_id' => 'required|integer|exists:categories,id',
        ]);

        foreach ($validatedData['custom_category'] as $id => $customCategoryData) {
            $customCategoryData['user_id'] = Auth::user()->id;
            $customCategoryData['displayname'] = $customCategoryData['displayname'] ?? '';
            $customCategoryData['color'] = $customCategoryData['color'] ?? '';
            $customCategoryData['icon'] = $customCategoryData['icon'] ?? '';
            

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

        return redirect()->back()->with('success', 'Category saved successfully!');
    }
    

    /**
     * Display the specified resource.
     */
    public function show($categoryId)
    {  
        // First, try to find a custom category with the given categoryId
        $custom_category = CustomCategory::where('category_id', $categoryId)->where('user_id', Auth::user()->id)->first();

        
        // If a custom category is found, use it; otherwise, find the standard category
        $category = Category::where('id',$categoryId)->first();
        $category->name = $custom_category ? $custom_category->displayname : $category->name;

        return view('settings.categories.show', compact('category', 'custom_category'));
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        // Determine if the category is a custom category and fetch it
        $custom_category = CustomCategory::where('category_id', $category->id)->where('user_id', Auth::user()->id)->first();

        // Check if $custom_category is null and set default values based on $category
        if (!$custom_category) {
            // Initialize a new instance of CustomCategory with default values
            $defaultValues = [
                'displayname' => $category->name, 
                'color' => $category->color, 
                'icon' => $category->icon, 
            ];

            // Create a new CustomCategory instance with the default values
            $custom_category = new CustomCategory($defaultValues);
        }

        // Pass the category and custom_category to the view
        return view('settings.categories.edit', compact('category', 'custom_category'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, CustomCategory $custom_category)
    {
        // No need to fetch all categories here, just validate and update the current one
        $validatedData = $request->validate([
            'displayname' => 'required',
            'color' => 'required|string',
            'icon' => 'required|string',
            'user_id' => 'required|integer',
        ]);

        // Update the custom category with the validated data
        $isUpdated = $custom_category->update($validatedData);

        // Redirect to the show page for the updated CustomCategory
        return redirect()->route('categories.show', ['custom_category' => $custom_category->displayname])
            ->with('success', 'Custom category updated successfully');
    }

    public function save(Request $request, $categoryId)
    {
        $category = Category::findOrFail($categoryId);
        $customCategory = CustomCategory::where('category_id', $categoryId)->first();

        $data = $request->validate([
            'displayname' => 'required|string|max:255',
            'color' => 'required|string|max:7',
            'icon' => 'required|string|max:255',
            'user_id' => 'required|exists:users,id',
        ]);

        if ($customCategory) {
            // Update the existing custom category
            $customCategory->update($data);
        } else {
            // Create a new custom category
            $data['category_id'] = $categoryId;
            CustomCategory::create($data);
        }

        return redirect()->route('categories.index')->with('success', 'Category saved successfully.');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $custom_category = CustomCategory::find($id);

        if ($custom_category) {
            $custom_category->delete();
            return redirect()->route('categories.index')
                ->with('success', 'Custom category reset to default values successfully.');
        } else {
            return redirect()->route('categories.index')
                ->with('error', 'Custom category not found.');
        }
    }

    public function toggle(Category $category)
    {
        $category->toggleShow();
        return redirect()->back()->with('success', 'Category updated successfully');
    }

}
