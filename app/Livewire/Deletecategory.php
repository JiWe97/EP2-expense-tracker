<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;
use App\Models\Transaction;
use App\Models\Budget;
use Illuminate\Support\Facades\Auth;

class Deletecategory extends Component
{
    public $category;
    public $newCategoryId;

    protected $rules = [
        'newCategoryId' => 'nullable|exists:categories,id',
    ];

    /**
     * Mount the component with the given category.
     *
     * @param Category $category
     * @return void
     */
    public function mount(Category $category)
    {
        $this->category = $category;
    }

    /**
     * Delete the category and reassign transactions if a new category ID is provided.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteCategory()
    {
        $this->validate();

        if ($this->newCategoryId) {
            // Check that the new category has the same is_income value
            $newCategory = Category::where('id', $this->newCategoryId)
                                   ->where('user_id', Auth::id())
                                   ->firstOrFail();
            if ($newCategory->is_income !== $this->category->is_income) {
                session()->flash('error', 'The new category must have the same type (income/expense) as the one being deleted.');
                return redirect()->route('categories.index');
            }

            // Reassign transactions to the new category
            Transaction::where('category_id', $this->category->id)->update(['category_id' => $this->newCategoryId]);

            // Reassign budget categories to the new category
            $budgets = Budget::whereHas('categories', function ($query) {
                $query->where('category_id', $this->category->id);
            })->get();

            foreach ($budgets as $budget) {
                $budget->categories()->detach($this->category->id);
                $budget->categories()->attach($this->newCategoryId);
            }

            // Ensure the original category is deleted
            $this->category->forceDelete();
        } else {
            // Perform a soft delete, keeping the category name in transactions
            $this->category->delete();
        }

        session()->flash('success', 'Category deleted successfully and transactions reassigned or category soft deleted.');

        return redirect()->route('categories.index');
    }

    /**
     * Render the component view.
     *
     * @return \Illuminate\View\View
     */
    public function render()
    {
        return view('livewire.deletecategory', [
            'categories' => Category::where('id', '!=', $this->category->id)
                ->where('is_income', $this->category->is_income) // Ensure only categories with the same is_income value are listed
                ->where('user_id', Auth::id()) // Ensure only categories belonging to the authenticated user are listed
                ->get(),
        ]);
    }
}
