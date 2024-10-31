<?php

namespace App\Http\Controllers\Clientes;

use App\Http\Controllers\Controller;
use App\Models\Productos; // Asegúrate de que este modelo esté correctamente configurado
use App\Models\Categoria; // Asegúrate de que este modelo esté correctamente configurado
use Illuminate\Http\Request;
use Inertia\Inertia;

class CardProductosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Obtenemos los productos junto con su categoría
        $productos = Productos::with('categoria')->get();

        // Obtenemos todas las categorías
        $categorias = Categoria::all();

        // Retornamos la vista de Inertia con los productos y las categorías
        return Inertia::render('cardproductos/index', [
            'productos' => $productos,
            'categorias' => $categorias,
        ]);
    }

    // Otros métodos (create, store, show, edit, update, destroy) pueden ir aquí...
}
