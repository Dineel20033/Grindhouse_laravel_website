<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Admin\AdminProductController;
use App\Http\Controllers\Admin\AdminOrderController;
use App\Http\Controllers\Admin\AdminMessageController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

// Home Page (Fitness Store Landing)
Route::get('/', [HomeController::class, 'index'])->name('home');

// Public Products catalog (index + show)
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// About Us Page
Route::get('/about-us', function () {
    return view('about');
})->name('about');

// Contact Us Page
Route::get('/contact-us', [ContactController::class, 'index'])->name('contact.index');
Route::post('/contact-us', [ContactController::class, 'store'])->name('contact.store');

/*
|--------------------------------------------------------------------------
| User Dashboard & Profile (Breeze Default)
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Cart & Checkout
Route::middleware('auth')->group(function () {
    // Cart
    Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
    Route::post('/cart/add/{product}', [CartController::class, 'add'])->name('cart.add');
    Route::get('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

    // Checkout
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout', [CheckoutController::class, 'placeOrder'])->name('checkout.placeOrder');
    Route::get('/order/success/{id}', [CheckoutController::class, 'success'])->name('order.success');
});

// Allow viewing the cart without login (optional, but good practice. If strict requirement is ONLY add to cart redirects, viewing might still be allowed? 
// The user said "clicking the add to cart should directed login page", implying the action itself is protected.
// Viewing cart usually doesn't need auth until you have items, but if we store cart in session irrespective of auth, index can be public.
// However, the current code was in the middleware group. Let's move index out if we want them to see an empty cart, or keep it in if "Cart" feature is members only.
// For now, I'll keep index inside as well since that seems to be the current design pattern, 
// AND the user ONLY asked about "clicking add to cart". 
// The middleware 'auth' on these routes ALREADY handles the redirection to login automatically.

// Re-verifying the route protection:
// Route::post('/cart/add/{product}', ...) is inside Route::middleware('auth').
// When an unauthenticated user hits this route (via the form submission or link), Laravel's Authenticate middleware throws AuthenticationException -> redirects to 'login'.
// So this behavior should ALREADY be working if the routes are set up this way.

// Let's check if the 'Add to Cart' button is using a POST form or a GET link.
// In product-card.blade.php it is an <a> tag: <a href="{{ route('products.show', $product) }}" ... > Add to Cart </a> which goes to show page?
// Wait, the Product Card's "Add to Cart" button goes to 'products.show' ?? 
// Let me check product-card.blade.php again.

/*
|--------------------------------------------------------------------------
| Admin Routes (SSP 2 Security Compliance)
|--------------------------------------------------------------------------
| These routes require the user to be logged in AND have the 'is_admin' status.
*/

Route::middleware(['auth', 'is_admin'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Product Management (CRUD)
    Route::resource('products', AdminProductController::class);

    // Category Management
    Route::resource('categories', \App\Http\Controllers\Admin\AdminCategoryController::class);

    // Order Management
    Route::get('orders', [AdminOrderController::class, 'index'])->name('orders.index');
    Route::delete('orders/{order}', [AdminOrderController::class, 'destroy'])->name('orders.destroy');

    // Message Management
    Route::get('messages', [AdminMessageController::class, 'index'])->name('messages.index');
    Route::delete('messages/{message}', [AdminMessageController::class, 'destroy'])->name('messages.destroy');
});

/*
|--------------------------------------------------------------------------
| Authentication Routes (Breeze)
|--------------------------------------------------------------------------
*/

require __DIR__ . '/auth.php';