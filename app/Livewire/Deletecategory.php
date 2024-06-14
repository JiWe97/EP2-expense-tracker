<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Category;
use App\Models\Transaction;

class Deletecategory extends Component
{
    public $category;
    public $newCategoryId;

    protected $rules = [
        'newCategoryId' => 'nullable|exists:categories,id',
    ];

    public function mount(Category $category)
    {
        $this->category = $category;
    }

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

    public function render()
    {
        return view('livewire.deletecategory', [
            'categories' => Category::where('id', '!=', $this->category->id)->get(),
        ]);
    }
}
