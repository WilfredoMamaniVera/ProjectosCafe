<?php
namespace App\Http\Controllers;

use App\Models\CarritoDetalle;
use App\Models\CarritoCompra;
use Illuminate\Http\Request;

class CarritoDetalleController extends Controller
{
    public function index($carritoCompraId)
    {
        $detalles = CarritoDetalle::where('carrito_compra_id', $carritoCompraId)->get();
        return response()->json($detalles);
    }

    public function store(Request $request, $carritoCompraId)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|integer|min:1',
            'precio_unico' => 'required|numeric|min:0',
        ]);

        $detalle = CarritoDetalle::create([
            'carrito_compra_id' => $carritoCompraId,
            'producto_id' => $request->producto_id,
            'cantidad' => $request->cantidad,
            'precio_unico' => $request->precio_unico,
        ]);

        return response()->json($detalle, 201);
    }

    public function update(Request $request, $id)
    {
        $request->validate(['cantidad' => 'required|integer|min:1']);
        
        $detalle = CarritoDetalle::findOrFail($id);
        $detalle->update($request->only('cantidad'));

        return response()->json($detalle);
    }

    public function destroy($id)
    {
        $detalle = CarritoDetalle::findOrFail($id);
        $detalle->delete();

        return response()->json(null, 204);
    }
}
