<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\backend;
use App\Models\user;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->backend = new backend();
    }
    protected $backend;
    private $companies;
    private $current_company;
    public function companies($id_emp){
        $rol =  auth()->user()->role;
        $emp =  auth()->user()->company;
        $id_usr = auth()->user()->id;
        $this->companies = $this->backend->get_companies($rol,$emp,$id_usr);
        $emp = ($id_emp == null)? auth()->user()->company:$id_emp;
        $comprobacion = false;
        for($i = 0; $i < count($this->companies); $i++)
        {
            if($this->companies[$i]['id_empresa'] == $emp)
            {
                $this->current_company = $this->companies[$i];
                $comprobacion = true;
                break;
            }
        }

        if(!$comprobacion){
            $this->current_company = $this->companies[0];
        }
        $response = [];
        $response[0] = $this->current_company;
        $response[1] = $this->companies;
        return $response;
    }

    public function cambio($id_emp)
    {
        $cambio = session()->get('cambio');
        if(null == $cambio || $cambio == $id_emp['id_empresa'])
        {
            $current = $this->companies($id_emp['id_empresa']);
            session()->put('empresa', $this->current_company); 
        }
        else
        {
            $current = $this->companies($cambio);
            session()->put('empresa', $current[0]);  
        }
        return $current;
    }
    
    public function request_change(Request $request)
    {
        $source = $request->_url;
        $code = $request->change_corporation;
        session()->put('cambio', $code);
        return redirect()->route($source);
    }
}
