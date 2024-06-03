<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Requests\Request;
use App\Models\Category;
use App\Http\Requests\CategoryRequest;
use App\Models\Budget;
use App\Http\Requests\BudgetRequest;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

//Categories
Route::get('/settings/categories', function () {
    return view('settings.categories.categories', ['categories' => Category::all()]);
})->name('categories');

Route::view('/settings/categories/create', 'settings.categories.create')
    ->name('categories.create');

Route::get('/settings/categories/{category}', function ($categoryId) {
    $category = Category::where('name', $categoryId)->first();
    return view('settings.categories.show', ['category' => $category]);
})->name('categories.show');

Route::get('/settings/categories/{category}/edit', function (category $category) {
    return view('settings.categories.edit', ['category' => $category]);
})->name('categories.edit');

Route::post('/settings/categories', function (CategoryRequest $request) {
    $category = Category::create($request->validated());
    return redirect()->route('categories', ['category' => $category->id])
        ->with('success', 'Category created successfully');
})->name('categories.store');

Route::put('/settings/categories/{category}', function (Category $category, CategoryRequest $request) {
    $category->update($request->validated());
    return redirect()->route('categories.show', ['category' => $category->name])
        ->with('success', 'category updated successfully');
})->name('categories.update');

Route::delete('/settings/categories/{category}', function (category $category) {
    $category->delete();
    return redirect()->route('categories')
        ->with('success', 'category deleted successfully');
})->name('categories.destroy');

Route::put('/settings/categories/{category}/toggle-show', function (Category $category) {
    $category->toggleShow();
    return redirect()->back()->with('success', 'Category updated successfully');
})->name('categories.toggle-show');


//budgets
Route::get('/settings/budgets', function () {
    return view('settings.budgets.budgets', ['budgets' => Budget::all()]);
})->name('budgets');

/* Route::view('/settings/budgets/create', 'settings.budgets.create', ['categories' => Category::all()])
    ->name('budgets.create'); */
Route::view('/settings/budgets/create', 'settings.budgets.create')
    ->name('budgets.create');

/* Route::get('/settings/budgets/{budget}/edit', function (Budget $budget, Category $category) {
    return view('settings.budgets.edit', ['budget' => $budget, 'category' => $category]);
})->name('budgets.edit'); */
Route::get('/settings/budgets/{budget}/edit', function (Budget $budget) {
    return view('settings.budgets.edit', ['budget' => $budget]);
})->name('budgets.edit');

/* Route::post('/settings/budgets', function (BudgetRequest $request) {
    $budget = Budget::create($request->validated());
    return redirect()->route('budgets', ['budget' => $budget->id, 'category' => $category->id])
        ->with('success', 'Budget created successfully');
}) ->name('budgets.store'); */
Route::post('/settings/budgets', function (BudgetRequest $request) {
    $budget = Budget::create($request->validated());
    return redirect()->route('budgets', ['budget' => $budget->id])
        ->with('success', 'Budget created successfully');
})->name('budgets.store');

/* Route::put('/settings/budgets/{budget}', function (Budget $budget, Category $category, BudgetRequest $request) {
    $budget->update($request->validated());
    return redirect()->route('budgets', ['budget' => $budget->name, 'category' => $category->name])
        ->with('success', 'budget updated successfully');
}) ->name('budgets.update'); */
Route::put('/settings/budgets/{budget}', function (Budget $budget, BudgetRequest $request) {
    $budget->update($request->validated());
    return redirect()->route('budgets', ['budget' => $budget->name])
        ->with('success', 'budget updated successfully');
})->name('budgets.update');

Route::delete('/settings/budgets/{budget}', function (Budget $budget) {
    $category->delete();
    return redirect()->route('budgets')
        ->with('success', 'budget deleted successfully');
})->name('budgets.destroy');
