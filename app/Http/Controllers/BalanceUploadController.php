<?php

namespace App\Http\Controllers;

use App\Imports\ImportAccountMaster;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\backend;
use Illuminate\Support\Facades\Storage;
use PhpParser\Node\Stmt\TryCatch;

class BalanceUploadController extends Controller
{
    protected $backend;
    public function __construct()
    {    
        // $this->middleware('auth');
        $this->backend = new backend();
    }

    public function buc_uploadFile($file)
    {
        
        try {
            // Validar y procesar el archivo Excel
            $import = new ImportAccountMaster($this->backend);
            if (!$import->estructuraEsperada($file)) {
                return response()->json(['error' => 'Las cabeceras o el archivo Excel no coinciden con la plantilla, verifica los nombres e intenta nuevamente.']);
            } else if ($import->hasEmptyRequiredFields($file)) {
                return response()->json(['error' => 'Hay al menos una fila con un dato obligatorio vacío.']);
            }

            //luego de las validaciones se envía el archivo y el modelo al objeto excel
            Excel::import($import, $file);
            if ($import->importWasSuccessful()) {
                $rowsImported = $import->getRowCount();
                return response()->json(['success' => ("$rowsImported filas importadas correctamente.")]);
            } else {
                return redirect()->back()->with(['error' => 'Ocurrió un error durante la importación.']);
            }
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Maneja los errores de validación
            return response()->json(['error' => $e->getMessage()]);
        } catch (\Exception $e) {
            // Maneja otras excepciones
            return response()->json(['error' => 'Ocurrió un error durante la importación.']);
        }
    }
}
