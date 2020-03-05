<?php

namespace App\Http\Controllers;

use App\Agentes as Usuarios;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class usuariosController extends Controller
{
    public function index()
    {
        $datos['usuarios'] = Usuarios::where('idrol','=','2')->get();
        return view('usuarios.index', $datos);
    }

    public function create()
    {
        return view('usuarios.create');
    }

    public function store(Request $request)
    {
        //Campos para validación
        $campos = [
            'usuario' => 'required|string|max:100',
            'password' => 'required|string|max:100',
            'confirmar' => 'required|string|max:100',
            'email' => 'required|string|max:100',
            'imagen' => 'max:10000|mimes:jpeg,png,jpg'
        ];
        
        $datosUsuario = request()->except('_token');
        
        if(!isset($datosUsuario['chkuser'])){
            $datosUsuario['chkuser']=0;
        }

        //print_r($datosUsuario);

        if($datosUsuario['chkuser']==1){
            $campos +=[
            'nomagente' => 'required|string|max:100',
            'apeagente' => 'required|string|max:100',
            'celular' => 'required|string|max:30',
            'telefono' => 'string|max:30',
            'dpto' => 'required|string|max:100',
            'descripcionesp_agente'=>'string|max:100',
            'descripcioning_agente'=>'string|max:100'
            ];
        }

        $Mensaje = ["required" => ':attribute es requerido'];
        $this->validate($request, $campos, $Mensaje);

        if($datosUsuario['password']==$datosUsuario['confirmar']){
            $datosUsuario = request()->except('chkuser','confirmar','_token');
            if($request->hasFile('imagen')){
                $datosUsuario['imagen']=$request->file('imagen')->store('uploads','public');
            }
            $datosUsuario['idrol']=2;
            //print_r($datosUsuario);
            Usuarios::insert($datosUsuario);
            return redirect('/usuarios');
        }else{
            return redirect('/usuarios_create')->with('Mensaje', 'La contraseña y su confirmación deben ser iguales');
        }
        
        //Para insertar los datos en la bd
        //DB::table('usuarios')->insert([$datosUsuario]);
        //$id = DB::getPdo()->lastInsertId();   
    }

    public function edit($id)
    {
        $usuario = Usuarios::findOrFail($id);
        return view('usuarios.edit', compact('usuario'));
    }

    public function update(Request $request, $id)
    {
        //Campos para validación
        $campos = [
            'usuario' => 'required|string|max:100',
            'password' => 'required|string|max:100',
            'confirmar' => 'required|string|max:100',
            'email' => 'required|string|max:100',
            'imagen' => 'max:10000|mimes:jpeg,png,jpg'
        ];
        
        $datosUsuario = request()->except('_token');
        
        if(!isset($datosUsuario['chkuser'])){
            $datosUsuario['chkuser']=0;
        }

        //print_r($datosUsuario);

        if($datosUsuario['chkuser']==1){
            $campos +=[
            'nomagente' => 'required|string|max:100',
            'apeagente' => 'required|string|max:100',
            'celular' => 'required|string|max:30',
            'telefono' => 'string|max:30',
            'dpto' => 'required|string|max:100',
            'descripcionesp_agente'=>'string|max:100',
            'descripcioning_agente'=>'string|max:100'
            ];
        }

        $Mensaje = ["required" => ':attribute es requerido'];
        $this->validate($request, $campos, $Mensaje);

        if($datosUsuario['password']==$datosUsuario['confirmar']){
            $datosUsuario = request()->except('chkuser','confirmar','_token');
            if($request->hasFile('imagen')){
                $datosUsuario['imagen']=$request->file('imagen')->store('uploads','public');
            }
            $datosUsuario['idrol']=2;
            //print_r($datosUsuario);
            Usuarios::where('id','=',$id)->update($datosUsuario);
            return redirect('/usuarios');
        }else{
            return redirect('/usuarios_create')->with('Mensaje', 'La contraseña y su confirmación deben ser iguales');
        }

        //$datos['usuarios'] = Usuarios::get();
        //return redirect('usuarios')->with('Mensaje', 'Amenidad modificada con éxito');
    }

    public function destroy($id)
    {
        $datosUsuario = Usuarios::findOrFail($id);
        Storage::delete('public/'.$datosUsuario->imagen);
        Usuarios::destroy($id);
        return redirect('usuarios')->with('Mensaje', 'Amenidad eliminada con éxito');
    }
}
