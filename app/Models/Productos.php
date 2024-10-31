<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Productos extends Model
{
    use HasFactory;

    protected $fillable = [
        'producto_nombre', 
        'marca', 
        'descripcion', 
        'precio', 
        'stock', 
        'imagen', 
        'categoria_id'
    ];

    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
    public function detallesCarrito()
    {
        return $this->hasMany(CarritoDetalle::class);
    }
}
