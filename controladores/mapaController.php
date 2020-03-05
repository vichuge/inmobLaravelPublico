<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Negocios;
use DB;

class mapaController extends Controller
{
    public function index()
    {
        $datos['negocios']=DB::table('negocios')->get();
        return view('mapa_negocios.index',$datos);
    }

    public function vista($id)
    {
        $datos['negocio']=Negocios::where('id','=',$id)->get();
        $datos['negocios']=Negocios::get();
        return view('mapa_negocios.vista',$datos);
    }
}