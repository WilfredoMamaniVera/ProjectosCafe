<?php

namespace App\Http\Controllers;

use App\Models\CarritoCompra;
use App\Models\CarritoDetalle;
use App\Models\Productos; // Asegúrate de incluir el modelo de Productos
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

class CarritoCompraController extends Controller
{
    /**
     * Display the user's shopping cart.
     */
    public function index()
    {
        $user = Auth::user();

        // Cargar carrito con los detalles, incluyendo las relaciones necesarias
        $carrito = CarritoCompra::where('user_id', $user->id)
            ->with('detalles.producto.categoria') // Asegúrate de cargar la categoría
            ->first();

        if (!$carrito) {
            $carrito = CarritoCompra::create(['user_id' => $user->id]);
        }

        return Inertia::render('carritos/index', [
            'carrito' => $carrito,
        ]);
    }


    /**
     * Store a newly created cart in storage.
     */
    public function store()
    {
        $carrito = CarritoCompra::create([
            'user_id' => Auth::id(),
            'is_deleted' => false,
        ]);

        return response()->json($carrito, 201);
    }

    /**
     * Remove the specified cart from storage.
     */
    public function destroy($id)
    {
        $carrito = CarritoCompra::findOrFail($id);
        $carrito->delete();

        return response()->json(null, 204);
    }

    /**
     * Add a product to the cart.
     */

    public function addProduct(Request $request)
    {
        $validated = $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|integer|min:1',
        ]);

        $carrito = CarritoCompra::firstOrCreate(['user_id' => Auth::id()]);

        $producto = Productos::findOrFail($validated['producto_id']);
        $precio_unico = $producto->precio;

        $detalleExistente = $carrito->detalles()->where('producto_id', $validated['producto_id'])->first();

        if ($detalleExistente) {
            $detalleExistente->cantidad += $validated['cantidad'];
            $detalleExistente->save();
        } else {
            $detalle = new CarritoDetalle([
                'producto_id' => $validated['producto_id'],
                'cantidad' => $validated['cantidad'],
                'precio_unico' => $precio_unico,
            ]);
            $carrito->detalles()->save($detalle);
        }

        return response()->json(['carrito' => $carrito->load('detalles.producto')], 201);
    }


    public function removeProduct(Request $request)
    {
        $validated = $request->validate([
            'producto_id' => 'required|exists:productos,id',
        ]);

        $user = Auth::user();

        // Obtener el carrito del usuario
        $carrito = CarritoCompra::where('user_id', $user->id)->first();

        // Si no hay carrito, no hay nada que eliminar
        if (!$carrito) {
            return response()->json(['message' => 'El carrito no existe.'], 404);
        }

        // Encontrar el detalle del carrito por el producto_id
        $detalle = CarritoDetalle::where('carrito_compra_id', $carrito->id)
            ->where('producto_id', $validated['producto_id'])
            ->first();

        // Si no se encuentra el detalle, retorna un mensaje
        if (!$detalle) {
            return response()->json(['message' => 'El producto no está en el carrito.'], 404);
        }

        // Eliminar el detalle del carrito
        $detalle->delete();

        return response()->json(null, 204); // Retorna un 204 No Content
    }
}
