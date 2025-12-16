<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Movimiento extends Model
{
    use HasFactory;

    // campos permitidos para asignación masiva
    protected $fillable = [
        'user_id',
        'tipo',
        'cantidad',
        'fecha',
    ];

    // si quieres, también puedes definir casting de fechas
    protected $casts = ['fecha' => 'date',];
}
