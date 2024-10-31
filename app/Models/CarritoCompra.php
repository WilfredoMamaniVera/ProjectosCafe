<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarritoCompra extends Model
{
    protected $fillable = ['user_id', 'is_deleted'];

    public function detalles()
    {
        return $this->hasMany(CarritoDetalle::class);
    }
}
