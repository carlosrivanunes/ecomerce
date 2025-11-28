<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Models\Product;
// Importante para a rota de limpeza funcionar
use Darryldecode\Cart\Facades\CartFacade as Cart; 

// ===============================
// PÁGINA INICIAL
// ===============================
Route::get('/', function () {
    $featuredProducts = Product::latest()->take(3)->get();
    return view('home', ['products' => $featuredProducts]);
})->name('home');

// ===============================
// LISTAGEM DE PRODUTOS (PÚBLICA)
// ===============================
Route::get('products', [ProductController::class, 'index'])->name('products.index');

// ===============================
// CARRINHO (ABERTO)
// ===============================
Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
Route::post('/cart/add/{id}', [CartController::class, 'addToCart'])->name('cart.add');
Route::patch('/cart/update/{id}', [CartController::class, 'update'])->name('cart.update');
Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])->name('cart.remove');

// ===============================
// CHECKOUT (ABERTO)
// ===============================
Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
Route::get('/createintent', [CheckoutController::class, 'createintent'])->name('checkout.createintent');

// ===============================
// STRIPE - Criar sessão e callbacks
// ===============================
Route::post('/checkout/create-session', [CheckoutController::class, 'createSession'])
    ->name('checkout.createSession')
    ->middleware('auth'); // apenas usuários logados podem criar sessão

Route::get('/checkout/success', [CheckoutController::class, 'success'])->name('checkout.success');

Route::get('/checkout/cancel', [CheckoutController::class, 'cancel'])
    ->name('checkout.cancel'); // cancelamento pode ser aberto

// ===============================
// ROTA DE EMERGÊNCIA - LIMPAR CARRINHO
// ===============================
Route::get('/limpar-tudo', function () {
    Cart::clear();
    return redirect()->route('products.index')->with('success', 'Carrinho limpo com sucesso! Tente comprar novamente.');
});

// ===============================
// ROTAS QUE EXIGEM AUTENTICAÇÃO
// ===============================
Route::middleware('auth')->group(function () {

    // --- PERFIL ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // --- PEDIDOS ---
    Route::post('/checkout/store', [CheckoutController::class, 'store'])->name('checkout.store');
    Route::get('/meus-pedidos', [OrderController::class, 'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show'); 

    // --- FAVORITOS ---
    Route::get('/favoritos', [FavoriteController::class, 'index'])->name('favorites.index');
    Route::post('/favorites/toggle/{product}', [FavoriteController::class, 'toggle'])->name('favorites.toggle');

    // --- DASHBOARD USUÁRIO COMUM ---
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // ===============================
    // ÁREA ADMINISTRATIVA (MIDDLEWARE 'admin')
    // ===============================
    Route::middleware('admin')->group(function () {

        // Dashboard admin
        Route::get('/dashboard', function() {
            return view('dashboard'); // criar resources/views/admin/dashboard.blade.php
        })->name('admin.dashboard');

        // Produtos - admin
        Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
        Route::post('/products', [ProductController::class, 'store'])->name('products.store');
        Route::get('products/{product}/edit', [ProductController::class, 'edit'])->name('products.edit');
        Route::put('products/{product}', [ProductController::class, 'update'])->name('products.update');
        Route::delete('/products/{product}', [ProductController::class, 'destroy'])->name('products.destroy');
    });

    // --- DETALHES DO PRODUTO (USUÁRIOS LOGADOS) ---
    Route::get('products/{product}', [ProductController::class, 'show'])->name('products.show'); 
});

// ===============================
// AUTENTICAÇÃO
// ===============================
require __DIR__.'/auth.php';
