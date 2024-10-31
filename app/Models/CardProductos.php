<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CardProductos extends Model
{
    use HasFactory;

    protected $table = 'productos'; // Nombre de la tabla en la base de datos

    protected $fillable = [
        'nombre',
        'descripcion',
        'precio',
        'imagen',
        'categoria_id', // Relación con la categoría
    ];

    // Relación con la categoría (si tienes una tabla de categorías)
    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }

}
