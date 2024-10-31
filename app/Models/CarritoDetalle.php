<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarritoDetalle extends Model
{
    protected $fillable = ['carrito_compra_id', 'producto_id', 'cantidad', 'precio_unico'];

    public function producto()
    {
        return $this->belongsTo(Productos::class, 'producto_id');
    }
}
