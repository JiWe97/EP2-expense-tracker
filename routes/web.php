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
use App\Http\Controllers\PayoffController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PDFController;
use App\Http\Controllers\DashboardController;


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

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified'])->name('dashboard');
});

// PDF Generation Route
Route::get('/pdf', [PDFController::class, 'generatePDF'])->name('pdf');;

// Transaction Routes
Route::middleware('auth')->group(function () {
    Route::get('/transactions/import', [TransactionController::class, 'showImportForm'])->name('transactions.import');
    Route::post('/transactions/preview', [TransactionController::class, 'preview'])->name('transactions.preview');
    Route::post('/transactions/import', [TransactionController::class, 'import'])->name('transactions.import');
    Route::get('/transactions', [TransactionController::class, 'index'])->name('transactions.index');
    Route::resource('/transactions', TransactionController::class);
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
Route::get('/banking-record/{bankingRecord}/edit', [BankController::class, 'edit'])->name('edit.banking.record');
Route::put('/banking-record/{bankingRecord}', [BankController::class, 'update'])->name('update.banking.record.put');


// Goal and Goal Transaction Routes
Route::middleware('auth')->group(function () {
    Route::resource('/goals', GoalController::class);
    Route::get('/goal_transactions/create/{goalId}', [GoalTransactionController::class, 'create'])->name('goal_transactions.create');
    Route::post('/goal_transactions', [GoalTransactionController::class, 'store'])->name('goal_transactions.store');
    Route::resource('/goal_transactions', GoalTransactionController::class)->except(['create', 'store']);
});

// Payoff Routes
Route::middleware('auth')->group(function () {
    Route::resource('/payoffs', PayoffController::class);
});
