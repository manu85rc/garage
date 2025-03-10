<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Estacionamiento extends Model
{
    use HasFactory;

    protected $table = 'estacionamientos';
    
    protected $fillable = [
        'patente',
        'ingreso',
        'salida',
        'servicio',
        'total'
    ];

    protected $casts = [
        'ingreso' => 'datetime',
        'salida' => 'datetime',
        'total' => 'decimal:2'
    ];
}