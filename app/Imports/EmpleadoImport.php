<?php

namespace App\Imports;

use App\Models\Empleados;
use Maatwebsite\Excel\Concerns\ToModel;

class EmpleadoImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Empleados([
            'NUMERO DE IDENTIFICACION DEL EMPLEADO' => $row[0],
            'NOMBRE EMPLEADO' => $row[1],        
            'CARGO' => $row[2],    
            'PAIS' => $row[3],        
            'CIUDAD' => $row[4],
            'FECHA TRANSACCION' => $row[5],        
            'CONCEPTO DE PAGO' => $row[6],        
            'VALOR DEL PAGO' => $row[7]
        ]);
    }
}
