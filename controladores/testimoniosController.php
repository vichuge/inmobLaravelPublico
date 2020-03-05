<?php

namespace App\Http\Controllers;

use DB;
use App\Testimonios;
use Illuminate\Http\Request;

class testimoniosController extends Controller
{
    public function index()
    {
        $datos['testimonios'] = Testimonios::get();
        return view('testimonios.index', $datos);
    }

    public function create()
    {
        return view('testimonios.create');
    }

    public function store(Request $request)
    {
        //Campos para validación
        $campos = [
            'nompersona' => 'required|string|max:100',
            'empresa' => 'string|max:100',
            'localidad' => 'required|string|max:100',
            'nomtestimonioesp' => 'required|string|max:100',
            'nomtestimonioing' => 'string|max:100',
            'publicar_en' => 'required',
        ];
        //Mensaje para la validación
        $Mensaje = ["required" => ':attribute es requerido'];

        //Ejecutar la validación
        $this->validate($request, $campos, $Mensaje);


        // Para tomar los datos del formulario excepto el token
        $datosTestimonio = request()->except('_token');

        //Para insertar los datos en la bd
        //Testimonios::insert($datosTestimonio);
        DB::table('testimonios')->insert([$datosTestimonio]);
        $id = DB::getPdo()->lastInsertId();

        //Tomar los datos de la bd y anexarlos a la variable $datos['empleados']
        //$datos['testimonios'] = Testimonios::paginate(5);

        //imprimir la vista empleados.index anexandole la variable $datos
        //$id=Testimonios::getPdo()->lastInsertId();
        return redirect('testimonios_contespanol/' . $id);
    }

    public function edit($id)
    {
        $testimonio = Testimonios::findOrFail($id);
        return view('testimonios.edit', compact('testimonio'));
    }

    public function update(Request $request, $id)
    {
        //Campos para validación
        $campos = [
            'nompersona' => 'required|string|max:100',
            'empresa' => 'string|max:100',
            'localidad' => 'required|string|max:100',
            'nomtestimonioesp' => 'required|string|max:100',
            'nomtestimonioing' => 'string|max:100',
            'publicar_en' => 'required',
        ];

        $Mensaje = ["required" => 'El :attribute es requerido'];

        $this->validate($request, $campos, $Mensaje);

        $datosEmpleado = request()->except('_token');

        Testimonios::where('id', '=', $id)->update($datosEmpleado);

        $datos['testimonios'] = Testimonios::get();
        return redirect('testimonios')->with('Mensaje', 'Amenidad modificada con éxito');
    }

    public function destroy($id)
    {
        $amenidad = Testimonios::findOrFail($id);
        Testimonios::destroy($id);
        return redirect('testimonios')->with('Mensaje', 'Amenidad eliminada con éxito');
    }

    public function contesp($id)
    {
        $datos['testimonio'] = Testimonios::findOrFail($id);
        return view('testimonios.contesp', $datos);
    }

    public function conting($id)
    {
        $datos['testimonio'] = Testimonios::findOrFail($id);
        return view('testimonios.conting', $datos);
    }

    public function contesp_store(Request $request,$id)
    {
        //Campos para validación
        $campos = [
            'contenido_esp' => 'required|string|max:10000'
        ];
        
        $Mensaje = ["required" => 'Es necesario tener contenido para poder guardar'];
        
        $this->validate($request, $campos, $Mensaje);
        
        $datosEmpleado = request()->except('_token');
        
        Testimonios::where('id', '=', $id)->update($datosEmpleado);
        
        $datos['testimonios'] = Testimonios::get();
        return redirect('testimonios_contingles/'.$id);
    }

    public function conting_store(Request $request,$id)
    {
        //Campos para validación
        $campos = [
            'contenido_ing' => 'required|string|max:10000'
        ];
                
        $Mensaje = ["required" => 'Es necesario tener contenido para poder guardar'];
                
        $this->validate($request, $campos, $Mensaje);
                
        $datosEmpleado = request()->except('_token');
                
        Testimonios::where('id', '=', $id)->update($datosEmpleado);
                
        $datos['testimonios'] = Testimonios::get();
        return redirect('testimonios');
    }

    public function ajax($id)
    {
        echo 'si entre xD';

        $datosTestimonio=Testimonios::findOrFail($id);
        if($datosTestimonio['activa']=='1'){
            $updateTestimonio=['activa'=>'0']; 
        }elseif($datosTestimonio['activa']=='0'){
            $updateTestimonio=['activa'=>'1']; 
        }else{
            //print_r('Error!');
        }
        
        Testimonios::where('id','=',$id)->update($updateTestimonio);
    }
}
