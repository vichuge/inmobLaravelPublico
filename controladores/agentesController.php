<?php

namespace App\Http\Controllers;

//use DB;
use App\Agentes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class agentesController extends Controller
{
    public function index()
    {
        $datos['agentes'] = Agentes::where('idrol','!=','1')->get();
        return view('agentes.index', $datos);
    }

    public function create()
    {
        return view('agentes.create');
    }

    public function store(Request $request)
    {
        //Campos para validación
        $campos = [
            'nomagente' => 'required|string|max:100',
            'apeagente' => 'required|string|max:100',
            'email' => 'required|string|max:100',
            'celular' => 'required|string|max:100',
            'dpto' => 'required|string|max:100',
            'descripcionesp_agente'=>'max:700',
            'descripcioning_agente'=>'max:700',
            'imagen' => 'max:10000|mimes:jpeg,png,jpg'
        ];
        
        $datosAgente = request()->except('_token');
        //print_r($datosAgente);
        if(isset($datosAgente['chkuser'])){
            $campos +=[
                'usuario' => 'required|string|max:100',
                'password' => 'required|string|max:100',
                'confirmar' => 'required|string|max:100'
            ];
            $datosAgente['idrol']=2;
        }else{
            $datosAgente['idrol']=3;
        }

        $Mensaje = ["required" => ':attribute es requerido'];
        $this->validate($request, $campos, $Mensaje);
        
        if($datosAgente['password']==$datosAgente['confirmar']){
            if($request->hasFile('imagen')){
                $imagenAgente=$request->file('imagen')->store('uploads','public');
            }
            
            if(isset($datosAgente['chkuser'])){
                $idRol=2;
            }else{
                $idRol=3;
            }

            $datosAgente = request()->except('chkuser','confirmar','_token');
            $datosAgente['idrol']=$idRol;
            if(isset($imagenAgente)){
                $datosAgente['imagen']=$imagenAgente;
            }
            
            Agentes::insert($datosAgente);
        }

        return redirect('/agentes');
    }

    public function edit($id)
    {
        $agente = Agentes::findOrFail($id);
        return view('agentes.edit', compact('agente'));
    }

    public function update(Request $request, $id)
    {

        //Campos para validación
        $campos = [
            'nomagente' => 'required|string|max:100',
            'apeagente' => 'required|string|max:100',
            'email' => 'required|string|max:100',
            'celular' => 'required|string|max:100',
            'dpto' => 'required|string|max:100',
            'descripcionesp_agente'=>'max:700',
            'descripcioning_agente'=>'max:700',
            'imagen' => 'max:10000|mimes:jpeg,png,jpg'
        ];

        if(isset($datosAgente['chkuser'])){
            $campos +=[
                'usuario' => 'required|string|max:100',
                'password' => 'required|string|max:100',
                'confirmar' => 'required|string|max:100'
            ];
        }

        $datosAgente = request()->except('_token');
        //print_r($datosAgente);
        $Mensaje = ["required" => ':attribute es requerido'];
        $this->validate($request, $campos, $Mensaje);
        
        if($datosAgente['password']==$datosAgente['confirmar']){
            if($request->hasFile('imagen')){

                //eliminar imagen
                $imgAnterior=Agentes::findOrFail($id);
                Storage::delete('public/'.$imgAnterior->imagen);

                $imgNueva=$request->file('imagen')->store('uploads','public');
            }
               
            if(isset($datosAgente['chkuser'])){
                if($datosAgente['chkuser']=='on'){
                    $idRol=2;
                }else{
                    $idRol=3;
                }
            }else{
                $idRol=3;
            }

            $datosAgente = request()->except('chkuser','confirmar','_token');
            if(isset($imgNueva)){
                $datosAgente['imagen']=$imgNueva;
            }
            $datosAgente['idrol']=$idRol;
            //print_r($datosAgente);
            Agentes::where('id', '=', $id)->update($datosAgente);
        }
        return redirect('agentes')->with('Mensaje', 'Amenidad modificada con éxito');
    }

    public function destroy($id)
    {
        $datosAgente = Agentes::findOrFail($id);
        Storage::delete('public/'.$datosAgente->imagen);
        Agentes::destroy($id);
        return redirect('agentes')->with('Mensaje', 'Amenidad eliminada con éxito');
    }
}
