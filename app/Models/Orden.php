<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orden extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', // Asegúrate de incluir esto
        'direccion',
        'metodo_pago',
        'total',
        // Agrega otros campos si es necesario
    ];
}
