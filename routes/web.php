<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Requests\Request;
use App\Models\Category;
use App\Http\Requests\CategoryRequest;
use App\Http\Controllers\CategoryController;
use App\Models\Budget;
use App\Http\Requests\BudgetRequest;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\TransactionController;
use App\Models\Transaction;
use App\Http\Requests\TransactionRequest;
use App\Http\Controllers\FileUploadController;


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

// Route::resource('/dashboard/transaction', [TransactionController::class, 'index'])
//     ->name('transactions.index');
Route::get('/history', [TransactionController::class, 'show'])->name('transactions.show');
Route::get('/search', [TransactionController::class, 'search'])->name('transactions.search');

Route::view('/dashboard/transaction', 'transaction')
    ->name('transactions.create');

Route::post('/dashboard/transaction', function (TransactionRequest $request) {
    $transaction = Transaction::create($request->validated());
    return redirect()->route('dashboard', ['transaction' => $transaction])
        ->with('success', 'Transaction created successfully');
})->name('transactions.store');

// Upload pfp
Route::post('/uploads', [FileUploadController::class, 'store']);

//CATEGORIES
/* Route::middleware('auth')->group(function () { */
Route::resource('/settings/categories', CategoryController::class);
Route::put('/settings/categories/{category}/toggle-show', [CategoryController::class, 'toggle'])->name('categories.toggle-show');
/* }); */


//BUDGET
/* Route::middleware('auth')->group(function () { */
Route::resource('/settings/budgets', BudgetController::class);
/* }); */
