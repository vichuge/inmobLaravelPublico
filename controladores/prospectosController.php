<?php

namespace App\Http\Controllers;

use DB;
use App\Prospectos;
use App\Agentes;
use App\Propiedades;
use Illuminate\Http\Request;

class prospectosController extends Controller
{
    public function index(){
        $datos['prospectos'] = Prospectos::orderBy('fecha','desc')->get();
        return view('prospectos.index', $datos);
    }

    public function vista($id){
        $datos['prospecto'] = Prospectos::findOrFail($id);
        //$datos['propiedad']=Propiedades::where('id','=',$datos['prospecto']->idpropiedad);
        //$datos['agente']=Agentes::where('id','=',$datos['prospecto']->idagente);
        //print_r($datos['prospecto']);
        if($datos['prospecto']->idpropiedad != null){
            //$datos['propiedad']=DB::table('propiedades')->where('id','=',$datos['prospecto']->idpropiedad)->get();
            $datos['propiedad']=Propiedades::findOrFail($datos['prospecto']->idpropiedad);
            //$datos['agente']=DB::table('agentes')->where('id','=',$datos['propiedad']->idagente)->get();
            $datos['agente']=Agentes::findOrFail($datos['propiedad']->idagente);
        }
        
        
        //print_r($datos['propiedad'][0]->nompropiedadesp);
        //print_r($datos['propiedad']->nompropiedadesp);
        return view('prospectos.vista',$datos);
    }
}
