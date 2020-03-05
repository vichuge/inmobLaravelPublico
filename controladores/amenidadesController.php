<?php

namespace App\Http\Controllers;

use App\Amenidades;
use Illuminate\Http\Request;

class amenidadesController extends Controller
{
    public function index()
    {
        $datos['amenidades']=Amenidades::get();
        return view('amenidades.index', $datos);
    }

    public function create()
    {
        return view('amenidades.create');
    }

    public function store(Request $request)
    {
        //Campos para validación
        $campos = [
            'nomamenidadesp' => 'required|string|max:100',
            'nomamenidading' => 'max:100',
            'descripcion_amenidad' => 'required|string|max:100'
        ];
        //Mensaje para la validación
        $Mensaje = ["required" => ':attribute es requerido'];

        //Ejecutar la validación
        $this->validate($request, $campos, $Mensaje);


        // Para tomar los datos del formulario excepto el token
        $datosAmenidad = request()->except('_token') + ['status' => '1'];

        //Para insertar los datos en la bd
        Amenidades::insert($datosAmenidad);

        //Toma los datos y los pone en un json como respuesta
        //return response()->json($datosEmpleado);

        //Tomar los datos de la bd y anexarlos a la variable $datos['empleados']
        $datos['amenidades'] = Amenidades::paginate(5);

        //imprimir la vista empleados.index anexandole la variable $datos
        return redirect('amenidades')->with('Mensaje', 'Amenidad agregada con exito');
    }

    public function edit($id)
    { 
        $amenidad=Amenidades::findOrFail($id);
        return view('amenidades.edit',compact('amenidad'));
    }

    public function update(Request $request, $id)
    { 
        //Campos para validación
        $campos = [
            'nomamenidadesp' => 'required|string|max:100',
            'nomamenidading' => 'max:100',
            'descripcion_amenidad' => 'required|string|max:100'
        ];

        $Mensaje=["required"=>'El :attribute es requerido'];

        $this->validate($request,$campos,$Mensaje);

        $datosEmpleado=request()->except('_token','status');

        Amenidades::where('id','=',$id)->update($datosEmpleado);

        $datos['amenidades']=Amenidades::get();
        return redirect('amenidades')->with('Mensaje','Amenidad modificada con éxito');
    }

    public function destroy($id)
    {
        $amenidad=Amenidades::findOrFail($id);
        Amenidades::destroy($id);
        return redirect('amenidades')->with('Mensaje','Amenidad eliminada con éxito');
    }
}
