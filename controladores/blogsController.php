<?php

namespace App\Http\Controllers;

use DB;
use App\Blogs;
use Illuminate\Http\Request;

class blogsController extends Controller
{
    public function index()
    {
        $datos['blogs'] = Blogs::get();
        return view('blogs.index', $datos);
    }

    public function create()
    {
        return view('blogs.create');
    }

    public function store(Request $request)
    {
        //Campos para validación
        $campos = [
            'ubicacion' => 'required|string|max:100',
            'nomblogesp' => 'required|string|max:100',
            'nombloging' => 'max:100',
            'mostrar' => 'required|string|max:100',
            'publicar_sitio' => 'int|max:1',
            'imagen' => 'max:10000|mimes:jpeg,png,jpg'
        ];
        //Mensaje para la validación
        $Mensaje = ["required" => ':attribute es requerido'];

        //Ejecutar la validación
        $this->validate($request, $campos, $Mensaje);


        // Para tomar los datos del formulario excepto el token
        $datosBlog = request()->except('_token');

        if(!isset($datosBlog['publicar_sitio'])){
            $datosBlog+=['publicar_sitio'=>'0'];
        }

        if($request->hasFile('imgprincipal')){
            $datosBlog['imgprincipal']=$request->file('imgprincipal')->store('uploads','public');
        }
        //Para insertar los datos en la bd
        //Blogs::insert($datosBlog);
        DB::table('blogs')->insert([$datosBlog]);
        $id = DB::getPdo()->lastInsertId();

        //Tomar los datos de la bd y anexarlos a la variable $datos['empleados']
        //$datos['blogs'] = Blogs::paginate(5);

        //imprimir la vista empleados.index anexandole la variable $datos
        //$id=Blogs::getPdo()->lastInsertId();
        return redirect('blogs_contespanol/' . $id);
    }

    public function edit($id)
    {
        $blog = Blogs::findOrFail($id);
        return view('blogs.edit', compact('blog'));
    }

    public function update(Request $request, $id)
    {
        //Campos para validación
        $campos = [
            'ubicacion' => 'required|string|max:100',
            'nomblogesp' => 'required|string|max:100',
            'nombloging' => 'max:100',
            'mostrar' => 'required|string|max:100',
            'publicar_sitio' => 'int|max:1',
            'imagen' => 'max:10000|mimes:jpeg,png,jpg'
        ];

        $Mensaje = ["required" => 'El :attribute es requerido'];

        $this->validate($request, $campos, $Mensaje);

        $datosBlog = request()->except('_token');

        if(!isset($datosBlog['publicar_sitio'])){
            $datosBlog+=['publicar_sitio'=>'0'];
            //print_r($datosBlog);
        }

        if($request->hasFile('imgprincipal')){
            $datosBlog['imgprincipal']=$request->file('imgprincipal')->store('uploads','public');
        }

        Blogs::where('id', '=', $id)->update($datosBlog);

        $datos['blogs'] = Blogs::get();
        return redirect('blogs')->with('Mensaje', 'Amenidad modificada con éxito');
    }

    public function destroy($id)
    {
        $amenidad = Blogs::findOrFail($id);
        Blogs::destroy($id);
        return redirect('blogs')->with('Mensaje', 'Amenidad eliminada con éxito');
    }

    public function contesp($id)
    {
        $datos['blog'] = Blogs::findOrFail($id);
        return view('blogs.contesp', $datos);
    }

    public function conting($id)
    {
        $datos['blog'] = Blogs::findOrFail($id);
        return view('blogs.conting', $datos);
    }

    public function contesp_store(Request $request,$id)
    {
        //Campos para validación
        $campos = [
            'contenido_esp' => 'required|string|max:100000'
        ];
        
        $Mensaje = ["required" => 'Es necesario tener contenido para poder guardar'];
        
        $this->validate($request, $campos, $Mensaje);
        
        $datosEmpleado = request()->except('_token');
        
        Blogs::where('id', '=', $id)->update($datosEmpleado);
        
        $datos['blogs'] = Blogs::get();
        return redirect('blogs_contingles/'.$id);
    }

    public function conting_store(Request $request,$id)
    {
        //Campos para validación
        $campos = [
            'contenido_ing' => 'required|string|max:100000'
        ];
                
        $Mensaje = ["required" => 'Es necesario tener contenido para poder guardar'];
                
        $this->validate($request, $campos, $Mensaje);
                
        $datosEmpleado = request()->except('_token');
                
        Blogs::where('id', '=', $id)->update($datosEmpleado);
                
        $datos['blogs'] = Blogs::get();
        return redirect('blogs');
    }
}
