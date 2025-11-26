<?php


use App\Http\Controllers\BookController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\BookController as AdminBookController;
use App\Http\Controllers\Admin\AuthorController as AdminAuthorController;
use App\Http\Controllers\Admin\PublisherController as AdminPublisherController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\StockReportController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [BookController::class, 'index'])->name('books.index');
Route::get('/books/{book}', [BookController::class, 'show'])->name('books.show');


/*
|--------------------------------------------------------------------------
| Authentication Routes (Breeze)
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';


/*
|--------------------------------------------------------------------------
| User Profile
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


/*
|--------------------------------------------------------------------------
| Dashboard Redirect (for logged-in users)
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    // Redirect logged-in users to Admin Dashboard if admin
    if (auth()->check() && auth()->user()->hasRole('Admin')) {
        return redirect()->route('admin.dashboard');
    }
    // Otherwise redirect home
    return redirect()->route('books.index');
})->name('dashboard');



/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:Admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // ADMIN DASHBOARD ROUTE
        Route::get('/', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        // CRUD ROUTES
        Route::resource('authors', AdminAuthorController::class);
        Route::resource('publishers', AdminPublisherController::class);
        Route::resource('books', AdminBookController::class);

        //ADMIN SALES REPORT ROUTES
        Route::get('sales-report', [ReportController::class, 'salesReport'])
            ->name('sales.report');

        Route::get('sales-report/download', [ReportController::class, 'downloadSalesReport'])
            ->name('sales.report.download');

        //ADMIN STOCK REPORT ROUTES
        Route::get('stock-report', [StockReportController::class, 'index'])
            ->name('stock.report');

        Route::get('stock-report/download', [StockReportController::class, 'download'])
            ->name('stock.report.download');    
    });



/*
|--------------------------------------------------------------------------
| Cart and Checkout
|--------------------------------------------------------------------------
*/

Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{book}', [CartController::class, 'add'])->name('cart.add');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');
Route::get('/checkout', [CartController::class, 'checkout'])->name('cart.checkout');
Route::post('/checkout/process', [CartController::class, 'processCheckout'])
    ->name('cart.processCheckout');

//Search book - suggestion 
Route::get('/search-books', function () {
    $q = request('q');

    return \App\Models\Book::where('title', 'like', "%{$q}%")
        ->limit(5)
        ->get(['id', 'title']);
})->name('books.search');

Route::get('/invoice/{invoiceId}', [CartController::class, 'downloadInvoice'])
    ->name('invoice.download');


