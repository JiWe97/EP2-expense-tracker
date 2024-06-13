<?php

use App\Http\Controllers\BankController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FileUploadController;
use Illuminate\Support\Facades\Route;
use App\Http\Requests\Request;
use App\Models\Category;
use App\Http\Requests\CategoryRequest;
use App\Http\Controllers\CategoryController;
use App\Models\Budget;
use App\Http\Requests\BudgetRequest;
use App\Http\Controllers\BudgetController;
use App\Models\Transaction;
use App\Http\Requests\TransactionRequest;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\GoalController;
use App\Imports\BankStatementsImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\GraphController;


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

Route::get('/graph', [GraphController::class, 'index']);

Route::get('/dashboard/transaction', [TransactionController::class, 'show'])->name('transactions.show');

// Route::get('/dashboard/transaction/create', [TransactionController::class, 'create'])->name('transactions.create');

Route::post('/csv', [TransactionController::class, 'import'])->name('transactions.import');

Route::resource('/transactions', TransactionController::class);


// Upload pfp
Route::post('/uploads', [FileUploadController::class, 'store']);


//CATEGORIES
Route::middleware('auth')->group(function () {
    Route::resource('/settings/categories', CategoryController::class);
    Route::put('/settings/categories/{category}/toggle-show', [CategoryController::class, 'toggle'])->name('categories.toggle-show');
});


//BUDGET
Route::middleware('auth')->group(function () {
    Route::resource('/settings/budgets', BudgetController::class);
    Route::get('budgets/{budgetId}/history', [BudgetController::class, 'history'])->name('budgets.history');
});


//Bank
Route::post('/banking-record', [BankController::class, 'store'])->name('store.banking.record');
Route::delete('/banking-record/{bankingRecord}', [BankController::class, 'destroy'])->name('delete.banking.record');

//GOALS
Route::middleware('auth')->group(function () {
    Route::resource('/goals', GoalController::class);
});

