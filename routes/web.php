<?php

use App\Http\Controllers\BankController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\GoalController;
use App\Http\Controllers\GraphController;
use App\Http\Controllers\GoalTransactionController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';

// PDF Generation Route
Route::get('/pdf', [PDFController::class, 'generatePDF']);

// Graph Route
Route::get('/graph', [GraphController::class, 'index']);

// Transaction Routes
Route::middleware('auth')->group(function () {
    Route::resource('/transactions', TransactionController::class);
    Route::post('/csv', [TransactionController::class, 'import'])->name('transactions.import');
});

// File Upload Routes
Route::post('/uploads', [FileUploadController::class, 'store']);

// Category Routes
Route::middleware('auth')->group(function () {
    Route::resource('/settings/categories', CategoryController::class);
    Route::put('/settings/categories/{category}/toggle-show', [CategoryController::class, 'toggle'])->name('categories.toggle-show');
});

// Budget Routes
Route::middleware('auth')->group(function () {
    Route::resource('/budgets', BudgetController::class);
    Route::get('/budgets/{budgetId}/history', [BudgetController::class, 'history'])->name('budgets.history');
});

// Banking Routes
Route::post('/banking-record', [BankController::class, 'store'])->name('store.banking.record');
Route::delete('/banking-record/{bankingRecord}', [BankController::class, 'destroy'])->name('delete.banking.record');
Route::put('/banking-record/{bankingRecord}/add-balance', [BankController::class, 'addBalance'])->name('add.balance');

// Goal and Goal Transaction Routes
Route::middleware('auth')->group(function () {
    Route::resource('/goals', GoalController::class);
    Route::get('/goal_transactions/create/{goalId}', [GoalTransactionController::class, 'create'])->name('goal_transactions.create');
    Route::post('/goal_transactions', [GoalTransactionController::class, 'store'])->name('goal_transactions.store');
    Route::resource('/goal_transactions', GoalTransactionController::class)->except(['create', 'store']);
});
