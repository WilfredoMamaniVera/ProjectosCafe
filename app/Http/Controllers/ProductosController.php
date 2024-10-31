<?php

namespace App\Http\Controllers;

use App\Models\Productos;
use App\Models\Categoria; 
use Illuminate\Http\Request;
use Inertia\Inertia;
use App\Http\Requests\Productos\StoreRequest;
use App\Http\Requests\Productos\UpdateRequest;
use Illuminate\Support\Facades\Storage; // Asegúrate de agregar esta línea
use Illuminate\Support\Facades\Auth;

class ProductosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $productos = Productos::with('categoria')->get(); 
        return Inertia::render('productos/index', compact('productos'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        $categorias = Categoria::all(); 
        return Inertia::render('productos/create', [
            'categorias' => $categorias,
        ]);
    }

    public function edit($id)
    {
        $producto = Productos::find($id);
        $categorias = Categoria::all(); 
    
        return Inertia::render('productos/edit', [
            'producto' => $producto,
            'categorias' => $categorias,
        ]);
    }

    public function update(UpdateRequest $request, Productos $producto)
    {
        $data = $request->except('imagen');

        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            $routeName = $file->store('imagen', ['disk' => 'public']); // Cambiado a "imagen"
            $data['imagen'] = $routeName;

            if ($producto->imagen) {
                Storage::disk('public')->delete($producto->imagen);
            }
        }

        $producto->update($data);

        return to_route('productos.index', ['producto' => $producto->id])->with('Realizado', 'Productos Actualizados Correctamente!');
    }

    public function store(StoreRequest $request)
    {
        // Valida los datos de la solicitud (incluyendo la imagen y la categoría)
        $data = $request->validated(); // Usamos los datos ya validados de la solicitud.

        // Verifica si se ha subido una imagen
        if ($request->hasFile('imagen')) {
            $file = $request->file('imagen');
            $filePath = $file->store('imagen', ['disk' => 'public']); // Cambiado a "imagen"
            $data['imagen'] = $filePath; // Guarda la ruta de la imagen en el arreglo de datos.
        }

        // Crea el producto con los datos recibidos, incluyendo la categoría
        Productos::create($data);

        // Redirige a la lista de productos
        return to_route("productos.index")->with('success', 'Producto creado exitosamente.');
    }

    public function destroy(Productos $producto)
    {
        if ($producto->imagen) {
            Storage::disk('public')->delete($producto->imagen);
        }
        
        $producto->delete();

        return to_route('productos.index')->with('success', 'Producto eliminado con éxito.');
    }
}
