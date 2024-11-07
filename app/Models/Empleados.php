<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empleados extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'numero_identificacion',
        'nombre_empleado',        
        'cargo',    
        'pais',        
        'ciudad',
        'fecha_transaccion',        
        'concepto_pago',        
        'valor_pago'
    ];
}
