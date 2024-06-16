<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;
use App\Models\Transaction;

class DeleteCategory extends Component
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
            Transaction::where('category_id', $this->category->id)->update(['category_id' => $this->newCategoryId]);
            $this->category->delete();
        } else {
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
            'categories' => Category::where('id', '!=', $this->category->id)->get(),
        ]);
    }
}
