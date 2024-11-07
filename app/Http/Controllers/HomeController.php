<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;
use App\Models\backend;
use App\Models\Empleados;
use App\Imports\EmpleadoImport;
use App\Http\Controllers\BalanceUploadController as buc;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */

     protected $backend;
     private $buc;
     public function __construct()
     {
         $this->middleware('auth');
         $this->backend = new backend();
         $this->buc = new buc();
     }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }
    public function ingresar()
    {
        return view('home');
    }
    public function info()
    {
        phpinfo();
    }
    public function uploadFile(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx'
        ]);
        $file = $request->file('file');
        $response = $this->buc->buc_uploadFile($file);
        $responseData = json_decode($response->getContent(), true);
        return redirect()->back()->with($responseData);
    }
    public function show_create_companies()
    {  
        if (auth()->user()->role<=2) {
            return view('admin.create_companies');
        }else{
            return redirect('/')->with('error', 'No tienes permisos para acceder a esta sección.');
        }
    }
    public function show_upload_plantilla()
    {  
        return view('upload.upload_excel');
    }
    public function create_company(Request $request)
    {
        echo "<script>alert('dsfa');</script>";
        $razon_social = $request->razon_social;
        $numero_identificacion = $request->numero_identificacion;
        $this->backend->insert_empresa($razon_social,$numero_identificacion);

    }
}
