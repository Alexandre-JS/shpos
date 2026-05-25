<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\EntityController;
use App\Http\Controllers\Dashboard\DashboardController;
use App\Http\Controllers\Dashboard\ProductManagementController;
use App\Http\Controllers\Dashboard\EntitySettingsController;
use App\Http\Controllers\Admin\EntityApprovalController;
use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;

// Home (listagens públicas agregadas)
Route::get('/', [HomeController::class, 'index'])->name('home');

// Listagens específicas e busca
Route::get('/produtos', [HomeController::class, 'products'])->name('products');
Route::get('/servicos', [HomeController::class, 'services'])->name('services');
Route::get('/buscar', [HomeController::class, 'search'])->name('search');

// Detalhe de produto/serviço (binding via slug)
Route::get('/produto/{product:slug}', [ProductController::class, 'show'])->name('product.show');

// Perfil público da entidade (mini-site)
Route::get('/loja/{entity:slug}', [EntityController::class, 'show'])->name('entity.show');
// Listagem de entidades
Route::get('/entidades', [EntityController::class, 'index'])->name('entities.index');

// Página pública de categoria
Route::get('/categoria/{category:slug}', [\App\Http\Controllers\CategoryController::class, 'show'])->name('category.show');

// Registro de entidade + usuário (UC01)
Route::middleware('guest')->group(function () {
    Route::get('/register', [RegisterController::class, 'show'])->name('register.show');
    Route::post('/register', [RegisterController::class, 'store'])->name('register.store');

    Route::get('/login', [LoginController::class, 'show'])->name('login.show');
    Route::post('/login', [LoginController::class, 'login'])->name('login.perform');

    // Recuperação de password
    Route::get('/password/forgot', [ForgotPasswordController::class, 'show'])->name('password.request');
    Route::post('/password/forgot', [ForgotPasswordController::class, 'send'])->name('password.send');
    Route::get('/password/reset/{token}', [ResetPasswordController::class, 'show'])->name('password.reset');
    Route::post('/password/reset', [ResetPasswordController::class, 'update'])->name('password.update');
});

Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth')->name('logout');

// Dashboard (autenticado)
Route::middleware(['auth', \App\Http\Middleware\EnsureEntityOwner::class])->prefix('dashboard')->as('dashboard.')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('index');

    // Produtos / Serviços CRUD
    Route::get('/produtos', [ProductManagementController::class, 'index'])->name('products.index');
    Route::get('/produtos/novo', [ProductManagementController::class, 'create'])->name('products.create');
    Route::post('/produtos', [ProductManagementController::class, 'store'])->name('products.store');
    Route::get('/produtos/{product}/editar', [ProductManagementController::class, 'edit'])->name('products.edit');
    Route::put('/produtos/{product}', [ProductManagementController::class, 'update'])->name('products.update');
    Route::delete('/produtos/{product}', [ProductManagementController::class, 'destroy'])->name('products.destroy');
    Route::put('/produtos/{product}/imagens/{image}/primaria', [ProductManagementController::class, 'setPrimaryImage'])->name('products.images.primary');
    Route::put('/produtos/{product}/imagens/reordenar', [ProductManagementController::class, 'reorderImages'])->name('products.images.reorder');

    // Entidade settings
    Route::get('/entidade', [EntitySettingsController::class, 'edit'])->name('entity.settings.edit');
    Route::put('/entidade', [EntitySettingsController::class, 'update'])->name('entity.settings.update');

    // Estatísticas
    Route::get('/estatisticas', [\App\Http\Controllers\Dashboard\StatsController::class, 'index'])->name('stats');
});

// Área de administração
Route::middleware(['auth', \App\Http\Middleware\EnsureAdmin::class])->prefix('admin')->as('admin.')->group(function () {
    Route::get('/',                                           [AdminDashboardController::class, 'index'])->name('dashboard');

    // Gestão de empresas
    Route::get('/entidades',                                  [EntityApprovalController::class, 'index'])->name('entities.index');
    Route::get('/entidades/{entity}/editar',                  [EntityApprovalController::class, 'edit'])->name('entities.edit');
    Route::put('/entidades/{entity}',                         [EntityApprovalController::class, 'update'])->name('entities.update');
    Route::put('/entidades/{entity}/aprovar',                 [EntityApprovalController::class, 'approve'])->name('entities.approve');
    Route::put('/entidades/{entity}/rejeitar',                [EntityApprovalController::class, 'reject'])->name('entities.reject');
    Route::put('/entidades/{entity}/toggle',                  [EntityApprovalController::class, 'toggleActive'])->name('entities.toggle');
    Route::delete('/entidades/{entity}',                      [EntityApprovalController::class, 'destroy'])->name('entities.destroy');

    // Gestão de categorias
    Route::get('/categorias',                                 [AdminCategoryController::class, 'index'])->name('categories.index');
    Route::get('/categorias/nova',                            [AdminCategoryController::class, 'create'])->name('categories.create');
    Route::post('/categorias',                                [AdminCategoryController::class, 'store'])->name('categories.store');
    Route::get('/categorias/{category}/editar',               [AdminCategoryController::class, 'edit'])->name('categories.edit');
    Route::put('/categorias/{category}',                      [AdminCategoryController::class, 'update'])->name('categories.update');
    Route::put('/categorias/{category}/toggle',               [AdminCategoryController::class, 'toggleActive'])->name('categories.toggle');
    Route::delete('/categorias/{category}',                   [AdminCategoryController::class, 'destroy'])->name('categories.destroy');
});
