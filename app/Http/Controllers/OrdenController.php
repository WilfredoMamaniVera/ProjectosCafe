<?php

namespace App\Http\Controllers;

use App\Models\Orden;
use App\Models\CarritoCompra; // Asegúrate de que esta línea sea correcta
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class OrdenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Verificar si el usuario está autenticado
        if (!Auth::check()) {
            // Redirigir al usuario a la página de login
            return redirect()->route('login'); // Cambia 'login' por la ruta de tu login
        }

        $user = Auth::user();

        // Cargar carrito con los detalles, incluyendo las relaciones necesarias
        $carrito = CarritoCompra::where('user_id', $user->id)
            ->with('detalles.producto.categoria') // Asegúrate de cargar la categoría
            ->first();

        // Si no hay carrito, puedes decidir qué hacer. Aquí simplemente retornamos una vista vacía.
        if (!$carrito) {
            return Inertia::render('orden/index', [
                'carrito' => null, // Pasar null si no hay carrito
            ]);
        }

        // Renderizar la vista de orden y pasar el carrito
        return Inertia::render('orden/index', [
            'carrito' => $carrito, // Pasar el carrito a la vista
        ]);
    }

    /**
     * Crear una nueva orden a partir del carrito.
     */
    // OrdenController.php

    public function crearOrden(Request $request)
    {
        // Validar la solicitud
        $request->validate([
            'direccion' => 'required|string|max:255',
            'metodo_pago' => 'required|string|in:tarjeta,efectivo',
            'codigo_cupon' => 'nullable|string|max:255',
        ]);
    
        $user = Auth::user();
        $carrito = CarritoCompra::where('user_id', $user->id)->with('detalles.producto')->first();
        
        // Comprobar si el carrito está vacío
        if (!$carrito || $carrito->detalles->isEmpty()) {
            return response()->json(['message' => 'El carrito está vacío.'], 400);
        }
    
        // Crear la orden
        $orden = Orden::create([
            'user_id' => $user->id,
            'direccion' => $request->input('direccion'),
            'metodo_pago' => $request->input('metodo_pago'),
            'total' => $this->calcularTotal($carrito->detalles, $request->input('codigo_cupon')),
        ]);
    
        // Descontar el stock de cada producto en el carrito
        foreach ($carrito->detalles as $detalle) {
            $producto = $detalle->producto;
    
            // Verificar si hay suficiente stock
            if ($producto->stock < $detalle->cantidad) {
                return response()->json(['message' => 'No hay suficiente stock para el producto: ' . $producto->nombre], 400);
            }
    
            // Descontar el stock
            $producto->stock -= $detalle->cantidad;
            $producto->save();
        }
    
        // Vaciar el carrito después de crear la orden
        $carrito->detalles()->delete(); // Elimina los detalles del carrito
        $carrito->delete(); // Elimina el carrito
    
        return response()->json(['message' => 'Orden creada con éxito', 'order_id' => $orden->id], 201);
    }
    
    /**
     * Calcular el total de la orden incluyendo descuentos.
     */
    private function calcularTotal($detalles, $codigoCupon)
    {
        $total = $detalles->sum(function ($detalle) {
            return $detalle->precio_unico * $detalle->cantidad;
        });

        // Aquí puedes aplicar la lógica para calcular el descuento basado en el código del cupón
        $descuento = $this->calcularDescuento($codigoCupon);
        return $total - $descuento;
    }

    /**
     * Lógica para calcular el descuento basado en el código de cupón.
     */
    private function calcularDescuento($codigoCupon)
    {
        // Lógica de descuentos
        if ($codigoCupon === 'DESCUENTO10') {
            return 10; // Ejemplo de descuento fijo
        }
        return 0; // Sin descuento
    }
}
