<?php

namespace App\Http\Controllers;

use DB;
use App\Faqs;
use Illuminate\Http\Request;

class faqsController extends Controller
{
    public function index()
    {
        $datos['faqs'] = Faqs::get();
        return view('faqs.index', $datos);
    }

    public function create()
    {
        return view('faqs.create');
    }

    public function store(Request $request)
    {
        //Campos para validación
        $campos = [
            'nomfaqesp' => 'required|string|max:100',
            'nomfaqing' => 'max:100',
            'publicar_en' => 'required|string|max:10',
        ];
        //Mensaje para la validación
        $Mensaje = ["required" => ':attribute es requerido'];

        //Ejecutar la validación
        $this->validate($request, $campos, $Mensaje);
        

        // Para tomar los datos del formulario excepto el token
        $datosFaq = request()->except('_token');

        //print_r($datosFaq);
        $datosFaq+=['activa'=>'1'];
        //Para insertar los datos en la bd
        //Faqs::insert($datosFaq);
        DB::table('faqs')->insert([$datosFaq]);
        $id = DB::getPdo()->lastInsertId();

        //Tomar los datos de la bd y anexarlos a la variable $datos['empleados']
        //$datos['faqs'] = Faqs::paginate(5);

        //imprimir la vista empleados.index anexandole la variable $datos
        //$id=Faqs::getPdo()->lastInsertId();
        return redirect('faqs_contespanol/' . $id);
    }

    public function edit($id)
    {
        $faq = Faqs::findOrFail($id);
        return view('faqs.edit', compact('faq'));
    }

    public function update(Request $request, $id)
    {
        //Campos para validación
        $campos = [
            'nomfaqesp' => 'required|string|max:100',
            'nomfaqing' => 'max:100',
            'publicar_en' => 'required|string|max:10',
        ];

        $Mensaje = ["required" => 'El :attribute es requerido'];

        $this->validate($request, $campos, $Mensaje);

        $datosFaq = request()->except('_token');

        Faqs::where('id', '=', $id)->update($datosFaq);

        $datos['faqs'] = Faqs::get();
        return redirect('faqs')->with('Mensaje', 'Amenidad modificada con éxito');
    }

    public function destroy($id)
    {
        $amenidad = Faqs::findOrFail($id);
        Faqs::destroy($id);
        return redirect('faqs')->with('Mensaje', 'Amenidad eliminada con éxito');
    }

    public function contesp($id)
    {
        $datos['faq'] = Faqs::findOrFail($id);
        return view('faqs.contesp', $datos);
    }

    public function conting($id)
    {
        $datos['faq'] = Faqs::findOrFail($id);
        return view('faqs.conting', $datos);
    }

    public function contesp_store(Request $request,$id)
    {
        //Campos para validación
        $campos = [
            'contenido_esp' => 'required|string|max:10000'
        ];
        
        $Mensaje = ["required" => 'Es necesario tener contenido para poder guardar'];
        
        $this->validate($request, $campos, $Mensaje);
        
        $datosFaq = request()->except('_token');
        
        Faqs::where('id', '=', $id)->update($datosFaq);
        
        $datos['faqs'] = Faqs::get();
        return redirect('faqs_contingles/'.$id);
    }

    public function conting_store(Request $request,$id)
    {
        //Campos para validación
        $campos = [
            'contenido_ing' => 'required|string|max:10000'
        ];
                
        $Mensaje = ["required" => 'Es necesario tener contenido para poder guardar'];
                
        $this->validate($request, $campos, $Mensaje);
                
        $datosFaq = request()->except('_token');
                
        Faqs::where('id', '=', $id)->update($datosFaq);
                
        $datos['faqs'] = Faqs::get();
        return redirect('faqs');
    }

    public function ajax($id)
    {
        //echo 'si entre xD';

        $datosFaq=Faqs::findOrFail($id);
        if($datosFaq['activa']=='1'){
            $updateFaq=['activa'=>'0']; 
        }elseif($datosFaq['activa']=='0'){
            $updateFaq=['activa'=>'1']; 
        }else{
            print_r('Error!');
        }
   
        Faqs::where('id','=',$id)->update($updateFaq);
    }
}
