<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithChunkReading;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Facades\Excel; 
use Maatwebsite\Excel\Concerns\ToModel;
use App\Models\backend;

class ImportAccountMaster implements ToModel, WithHeadingRow, WithChunkReading, WithMultipleSheets
{
    protected $backend;
    private $importSuccessful = false; //nuevo
    private $rowCount = 0; //nuevo

    public function __construct(backend $backend)
    {
        $this->backend = $backend;
    }

    public function headingRow(): int
    {
        return 1;
    }

    public function conditionalSheets(): array
    {
        return [
            'Hoja1' => function ($row) {
                // Verifica si al menos un campo tiene un valor en la fila actual
                return count(array_filter($row->toArray())) > 0;
            },
        ];
    }

    public function getRowCount()
    {
        return $this->rowCount;
    }

    public function importWasSuccessful()
    {
        return $this->importSuccessful;
    }

    public function model(array $row)
    {
        // Verifica si al menos un campo tiene un valor en la fila actual
        if (count(array_filter($row)) === 0) {
            // Ignora la fila si está completamente vacía
            return null;
        }
        
        $this->importSuccessful = true;
        $this->rowCount++;

        $this->backend->insertempleados($row['numero_de_identificacion_del_empleado'],$row['nombre_empleado'],$row['cargo'],$row['pais'],$row['ciudad'],$row['fecha_transaccion'],$row['concepto_de_pago'],$row['valor_del_pago']);
        return null;
    }

    public function chunkSize(): int
    {
        return 1000; // Ajusta este valor según sea necesario
    }

    public function sheets(): array
    {
        // Retorna solo la instancia para la primera hoja
        return [
            0 => $this, // Procesar solo la primera hoja
        ];
    }

    // Función para verificar si hay campos obligatorios vacíos
    public function hasEmptyRequiredFields($file)
    {
        // Leer todo el contenido del archivo en un array
        $rows = Excel::toArray($this, $file);

        // Iterar sobre cada fila en la primera hoja
        foreach ($rows[0] as $row) {
            // Verifica si la fila está completamente vacía y omítela
            if (empty(array_filter($row))) {
                continue; // Ignora la fila totalmente vacía
            }

            // Definir los campos requeridos
            $requiredFields = ['NUMERO DE IDENTIFICACION DEL EMPLEADO','NOMBRE EMPLEADO','CARGO','PAIS','CIUDAD','FECHA TRANSACCION','CONCEPTO DE PAGO','VALOR DEL PAGO'];

            foreach ($requiredFields as $field) {
                // Verifica si el campo es obligatorio y está vacío en al menos una fila
                if (!isset($row[$field]) || $row[$field] === '') {
                    return true; // Al menos una fila tiene un dato obligatorio vacío
                }
            }
        }
        return false; // Todas las filas tienen datos completos
    }

    // Nueva función para verificar la estructura esperada del archivo
    public function estructuraEsperada($file)
    {
        // Obtener las cabeceras del archivo Excel
        $data = Excel::toArray(null, $file);
        $cabecerasExcel = $data[0][0];

        // Lista de cabeceras esperadas
        $estructuraEsperada = ['NUMERO DE IDENTIFICACION DEL EMPLEADO','NOMBRE EMPLEADO','CARGO','PAIS','CIUDAD','FECHA TRANSACCION','CONCEPTO DE PAGO','VALOR DEL PAGO'];

        // Ordenar ambas listas para comparación
        sort($estructuraEsperada);
        sort($cabecerasExcel);

        // Comparar si las cabeceras del archivo coinciden con la estructura esperada
        return $estructuraEsperada === $cabecerasExcel;
    }
}
