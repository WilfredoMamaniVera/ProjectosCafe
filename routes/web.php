<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoriasController; 
use App\Http\Controllers\ProductosController; 
use App\Http\Controllers\Clientes\CardProductosController; 
use App\Http\Controllers\UserController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarritoCompraController;
use App\Http\Controllers\CarritoDetallesController;
use App\Http\Controllers\OrdenController;

use Inertia\Inertia;

/*
|-------------------------------------------------------------------------- 
| Web Routes 
|-------------------------------------------------------------------------- 
| 
| Here is where you can register web routes for your application. These 
| routes are loaded by the RouteServiceProvider within a group which 
| contains the "web" middleware group. Now create something great! 
| 
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});





    //Categorias
    Route::prefix('dashboard')->group(function () {
        Route::get('categorias', [CategoriasController::class, 'index'])->name('categorias.index');        // Mostrar todas las categorías
        Route::get('categorias/create', [CategoriasController::class, 'create'])->name('categorias.create'); // Mostrar formulario de creación de categoría
        Route::post('categorias', [CategoriasController::class, 'store'])->name('categorias.store');         // Guardar una nueva categoría
        Route::get('categorias/{categoria}/edit', [CategoriasController::class, 'edit'])->name('categorias.edit'); // Mostrar formulario de edición de categoría
        Route::post('categorias/{categoria}', [CategoriasController::class, 'update'])->name('categorias.update'); // Actualizar categoría
        Route::delete('categorias/{categoria}', [CategoriasController::class, 'destroy'])->name('categorias.destroy'); // Eliminar categoría
    });

//Productos

Route::prefix('dashboard')->group(function () {
    Route::get('productos', [ProductosController::class, 'index'])->name('productos.index');
    Route::get('productos/create', [ProductosController::class,'create'])->name('productos.create');
    Route::post('productos', [ProductosController::class, 'store'])->name('productos.store');
    Route::get('productos/{producto}/edit', [ProductosController::class, 'edit'])->name('productos.edit');
    Route::post('productos/{producto}', [ProductosController::class, 'update'])->name('productos.update');
    Route::delete('productos/{producto}', [ProductosController::class, 'destroy'])->name('productos.destroy');
    
});


// Usuarios
Route::prefix('dashboard')->group(function () {
    Route::get('usuarios', [UserController::class, 'index'])->name('usuarios.index');
    Route::get('usuarios/create', [UserController::class, 'create'])->name('usuarios.create');
    Route::post('usuarios', [UserController::class, 'store'])->name('usuarios.store');
    Route::get('usuarios/{usuario}/edit', [UserController::class, 'edit'])->name('usuarios.edit');
    Route::post('usuarios/{usuario}', [UserController::class, 'update'])->name('usuarios.update');
    Route::delete('usuarios/{usuario}', [UserController::class, 'destroy'])->name('usuarios.destroy');
});



// Carrito de compra
Route::prefix('dashboard')->group(function () {
    Route::get('carritos', [CarritoCompraController::class, 'index'])->name('carritos.index');
    Route::post('carritos/agregar', [CarritoCompraController::class, 'addProduct'])->middleware('auth');
    Route::post('carritos/remove-product', [CarritoCompraController::class, 'removeProduct'])->middleware('auth');

});


// Carrito de compra
Route::prefix('dashboard')->group(function () {
    Route::get('/orden', [OrdenController::class, 'index'])->name('orden.index')->middleware('auth');
    Route::post('/orden', [OrdenController::class, 'crearOrden'])->name('orden.crear')->middleware('auth');
});





//CardProductos
// Ruta para mostrar los productos en una tarjeta
Route::get('cardproductos/index', [CardProductosController::class, 'index'])->name('cardproductos.index');




require __DIR__.'/auth.php';
