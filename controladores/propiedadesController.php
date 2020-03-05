<?php

namespace App\Http\Controllers;

use DB;
use App\Propiedades;
use App\Imagenes;
use App\Agentes;
use App\Colonias;
use App\Tipo_propiedad;
use App\Amenidades;
use App\Prospectos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class propiedadesController extends Controller
{
    public function index()
    {
        /*
        select 
            propiedades.id,
            propiedades.nompropiedadesp,
            propiedades.precio_venta,
            propiedades.precio_renta,
            propiedades.fechaingreso,
            agentes.nomagente,
            (select count(id) from prospectos where idpropiedad=propiedades.id) numprospectos,
            (select count(id) from visitas where idpropiedad=propiedades.id) numvisitas
        from propiedades
        join agentes on agentes.id=propiedades.idagente;
        */ 
        $datos['propiedades'] = DB::table('propiedades')
            ->join('agentes', 'propiedades.idagente','=','agentes.id')
            ->select(DB::raw('
                propiedades.id,
                propiedades.nompropiedadesp,
                propiedades.precio_venta,
                propiedades.precio_renta,
                propiedades.fechaingreso,
                agentes.nomagente,
                (select count(id) from prospectos where idpropiedad=propiedades.id) numprospectos,
                (select count(id) from visitas where idpropiedad=propiedades.id) numvisitas
            '))->get();
        $datos['imagenes']=DB::table('imagenes')
            ->select(DB::raw('
                id,
                idasignacion,
                principal,
                nomimagen
            '))->where('asignacion','=','propiedad')->where('principal','=','1')->get();
        //$datos['agentes']=DB::table('Agentes')->select(DB::raw('id,nomagente'))->get();
       
        //$datos['colonias']=DB::table('Colonias')->select(DB::raw('id,nomcolonia'))->get();
        
        return view('propiedades.index', $datos);
    }

    public function create()
    {
        $datos['agentes'] = Agentes::get();
        $datos['colonias'] = Colonias::get();
        return view('propiedades.create',$datos);
    }

    public function store(Request $request)
    {
        //Campos para validación
        $campos = [
            'nompropiedadesp' => 'required|string|max:100',
            'nompropiedading' => 'max:100',
            'descripcionesp' => 'max:500',
            'descripcioning' => 'max:500',
            'notas' => 'max:500',
            'idagente' => 'required|int|max:100',
            'idcolonia' => 'required|int|max:100'
        ];
        //Mensaje para la validación
        $Mensaje = ["required" => ':attribute es requerido'];

        //Ejecutar la validación
        $this->validate($request, $campos, $Mensaje);


        // Para tomar los datos del formulario excepto el token
        $datosPropiedad = request()->except('_token');
        //print_r($datosPropiedad);
        //Para insertar los datos en la bd

        
        DB::table('propiedades')->insert([$datosPropiedad]);
        $id = DB::getPdo()->lastInsertId();
        //print_r($id);

        //Tomar los datos de la bd y anexarlos a la variable $datos['empleados']
        //$datos['propiedades'] = Propiedades::paginate(5);

        //imprimir la vista empleados.index anexandole la variable $datos
        //$id=Propiedades::getPdo()->lastInsertId();

        return redirect('propiedades_edit_caracteristicas/' . $id);
    }

    public function edit($id)
    {
        $datos['agentes'] = Agentes::get();
        $datos['colonias'] = Colonias::get();
        $datos['propiedad'] = Propiedades::findOrFail($id);
        return view('propiedades.edit', $datos);
    }

    public function update(Request $request, $id)
    {
        //Campos para validación
        $campos = [
            'nompropiedadesp' => 'required|string|max:100',
            'nompropiedading' => 'max:100',
            'descripcionesp' => 'max:500',
            'descripcioning' => 'max:500',
            'notas' => 'max:500',
            'idagente' => 'required|int|max:100',
            'idcolonia' => 'required|int|max:100'
        ];

        $Mensaje = ["required" => 'El :attribute es requerido'];

        $this->validate($request, $campos, $Mensaje);

        $datosPropiedad = request()->except('_token');

        Propiedades::where('id', '=', $id)->update($datosPropiedad);

        //$datos['propiedades'] = Propiedades::get();
        return redirect('propiedades_edit/'.$id);
    }

    public function destroy($id)
    {
        $amenidad = Propiedades::findOrFail($id);
        Propiedades::destroy($id);
        return redirect('propiedades')->with('Mensaje', 'Amenidad eliminada con éxito');
    }

    public function caracteristicas($id)
    {
        $datos['propiedadesxcategorias']=DB::table('propiedadesxcategorias')->where('idpropiedad','=',$id)->get();
        $datos['unidades']=DB::table('unidades')->get();
        $datos['monedas']=DB::table('monedas')->get();
        $datos['categorias']=DB::table('categorias')->get();
        $datos['tipos_propiedad']=DB::table('tipo_propiedad')->get();
        $datos['propiedad'] = Propiedades::findOrFail($id);
        return view('propiedades.caracteristicas', $datos);
    }

    public function caracteristicas_store(Request $request,$id)
    {
        $campo=[
            'idtipo_propiedad'=>'require|string|max:50',
            'venta'=>'require|int|max:1',
            'renta'=>'require|int|max:1',
            'precio_venta'=>'max:20',
            'precio_renta'=>'max:20',
            'idunidad_renta'=>'max:20',
            'termycond'=>'max:500',
            'idmoneda_renta'=>'max:2',
            'idmoneda_venta'=>'max:2'
        ];
        $datosPropiedad=request()->except('_token','idcategoria');
        if(!isset($datosPropiedad['venta'])){
            $datosPropiedad['venta']=0;
            $datosPropiedad['precio_venta']=0;
        }
        if(!isset($datosPropiedad['renta'])){
            $datosPropiedad['renta']=0;
            $datosPropiedad['precio_renta']=0;
        }
        //print_r($datosPropiedad);

        Propiedades::where('id','=',$id)->update($datosPropiedad);

        //print_r('----------');
        DB::table('propiedadesxcategorias')->where('idpropiedad', '=', $id)->delete();

        $datosCategorias=$request['idcategoria'];
        //print_r($datosCategorias);
        

        foreach($datosCategorias as $dato){
            DB::table('propiedadesxcategorias')->insert([
                'idpropiedad'=>$id,
                'idcategoria'=>$dato
            ]);
            //print_r($dato);
        }


        return redirect('propiedades_edit_amenidades/'.$id);
    }

    public function amenidades($id)
    {
        $datos['amenidades']=Amenidades::get();
        $datos['propiedadesxamenidades']=DB::table('propiedadesxamenidades')->get();
        $datos['propiedad'] = Propiedades::findOrFail($id);
        return view('propiedades.amenidades',$datos);
    }

    public function amenidades_store(Request $request,$id)
    {
        DB::table('propiedadesxamenidades')->where('idpropiedad', '=', $id)->delete();

        $datosAmenidades=$request['idamenidad'];
        //print_r($datosAmenidades);
        foreach($datosAmenidades as $dato){
            DB::table('propiedadesxamenidades')->insert([
                'idpropiedad'=>$id,
                'idamenidad'=>$dato
            ]);
        }
        return redirect('propiedades_edit_publicacion/'.$id);
    }

    public function publicacion($id)
    {
        $datos['propiedad']=Propiedades::findOrFail($id);
        $datos['banderines']=DB::table('banderines')->get();

        return view('propiedades.publicacion',$datos);
    }

    public function publicacion_store(Request $request,$id)
    {
        $datosPropiedad=request()->except('_token');
        

        if(!isset($datosPropiedad['marca_agua'])){
            $datosPropiedad['marca_agua']=0;
        }
        //print_r($datosPropiedad);

        Propiedades::where('id','=',$id)->update($datosPropiedad);
        return redirect('propiedades_edit_propietario/'.$id);
    }

    public function propietario($id)
    {
        $datos['propiedad']=Propiedades::findOrFail($id);
        return view('propiedades.propietario',$datos);
    }

    public function propietario_store(Request $request,$id)
    {
        $campos=[
            'nompropietario'=>'required|string|max:50',
            'apepropietario'=>'required|string|max:50',
            'direccionpropietario'=>'required|max:100',
            'telpropietario'=>'required|max:100',
            'emailpropietario'=>'required|max:50'
        ];
        
        $Mensaje = ["required" => 'El :attribute es requerido'];
        $this->validate($request, $campos, $Mensaje); //Por alguna extraña razon, el validador aqui no funciona //18-dic Por alguna extraña razon, funciona de nuevo :v
        $datosPropiedad = request()->except('_token');
        Propiedades::where('id', '=', $id)->update($datosPropiedad);
        return redirect('propiedades_edit_configuracion/'.$id);
    }

    public function configuracion($id)
    {
        $datos['unidades']=DB::table('unidades')->get();
        $datos['propiedad']=Propiedades::findOrFail($id);
        return view('propiedades.configuracion',$datos);
    }

    public function configuracion_store(Request $request,$id)
    {
        //Campos para validación
        $campos = [
            'superficie' => 'required|int|max:1000000',
            'frente' => 'required|int|max:1000000',
            'fondo' => 'required|int|max:1000000',
            'construccion' => 'required|int|max:1000000'
        ];
        //Mensaje para la validación
        $Mensaje = ["required" => ':attribute es requerido'];

        //Ejecutar la validación
        $this->validate($request, $campos, $Mensaje);

        $datosPropiedad=request()->except('_token');
        Propiedades::where('id','=',$id)->update($datosPropiedad);

        return redirect('propiedades_edit_multimedia/'.$id);
    }

    public function multimedia($id)
    {
        $match = ['idasignacion' => $id, 'asignacion' => 'propiedad'];
        $datos['imagenes'] = Imagenes::where($match)->orderBy('principal', 'desc')->get();

        $matchP = ['idasignacion' => $id, 'asignacion' => 'propiedad', 'principal' => '1'];
        $datos['imagenesP'] = Imagenes::where($matchP)->get();

        $datos['propiedad']=Propiedades::findOrFail($id);
        return view('propiedades.multimedia',$datos);
    }

    public function multimedia_store(Request $request,$id)
    {
        $campos = ['nomimagen' => 'required|max:10000|mimes:jpeg,png,jpg'];
        //Mensaje para la validación
        $Mensaje = ['required' => 'Es requerido cargar una imagen'];
        //Ejecutar la validación
        $this->validate($request, $campos, $Mensaje);
        $datosImg = request()->except('_token');
        if ($request->hasFile('nomimagen')) {
            $datosImg['nomimagen'] = $request->file('nomimagen')->store('uploads', 'public');
        }
        $datosImg += [
            'idasignacion' => $id,
            'asignacion' => 'propiedad',
            'principal' => '0'
        ];
        Imagenes::insert($datosImg);

        //Asignar como principal solo si es la primera imagen insertada en esa colonia
        $match = ['idasignacion' => $id, 'asignacion' => 'propiedad'];
        $numImagenes = count(Imagenes::where($match)->get());
        if ($numImagenes == 1) {
            Imagenes::where($match)->update(['principal' => '1']);
        }
        //print_r($match);
        //print_r($numImagenes);

        return redirect('propiedades_edit_multimedia/'.$id);
    }

    public function multimedia_principal(Request $request, $id)
    {
        $datosP = request()->except('_token');

        $idImagen = $datosP['optionsRadios'];
        //print_r($idImagen);

        $match = ['idasignacion' => $id, 'asignacion' => 'propiedad', 'principal' => '1'];
        Imagenes::where($match)->update(['principal' => '0']);

        $match = ['id' => $idImagen, 'asignacion' => 'propiedad', 'principal' => '0'];
        Imagenes::where($match)->update(['principal' => '1']);

        return redirect('propiedades_edit_multimedia/'.$id);
    }

    public function elim_img($id,$idpropiedad)
    {
        //$match=['id'=>$id];
        $dataImage = Imagenes::findOrFail($id);

        if ($dataImage->principal == 1) {
            $match = ['asignacion' => 'propiedad', 'principal' => '0', 'idasignacion' => $dataImage->idasignacion];
            //Imagenes::where($match)->update(['principal' => '1']);
            DB::table('imagenes')->where($match)->limit(1)->update(['principal'=>'1']);
        }

        if(Storage::delete('public/'.$dataImage->nomimagen)){
            Imagenes::destroy($id);
        }
        return redirect('propiedades_edit_multimedia/'.$idpropiedad);
    }

    public function estadisticas($id)
    {
        $datos['numprospectos'] = DB::table('prospectos')->select(DB::raw('count(id) numprospectos'))->get();
        $datos['numvisitas']=DB::table('visitas')->select(DB::raw('count(id) numvisitas'))->get();
        $datos['propiedad']=Propiedades::findOrFail($id);
        $datos['prospectos']=DB::table('prospectos')->select(DB::raw('count(id) numpros,fecha'))->where('idpropiedad','=',$id)->groupBy('fecha')->get();
        $datos['visitas']=DB::table('visitas')->select(DB::raw('count(id) numvis,fecha'))->where('idpropiedad','=',$id)->groupBy('fecha')->get();
        return view('propiedades.estadisticas',$datos);
    }

    public function prospectos($id)
    {
        $datos['propiedad']=Propiedades::findOrFail($id);
        $datos['prospectos']=DB::table('prospectos')->where('idpropiedad','=',$id)->orderBy('fecha','desc')->get();
        return view('propiedades.prospectos',$datos); 
    }

    public function geolocalizacion($id){
        $datos['propiedad']=Propiedades::findOrFail($id);
        return view('propiedades.geolocalizacion',$datos);
    }

    public function geolocalizacion_store(Request $request,$id){
        //Campos para validación
        $campos = [
            'latitud' => 'required|max:18',
            'longitud' => 'required|max:18',
        ];
        //Mensaje para la validación
        $Mensaje = ["required" => ':attribute es requerido'];

        //Ejecutar la validación
        $this->validate($request, $campos, $Mensaje);

        $datosPropiedad=request()->except('_token');
        Propiedades::where('id','=',$id)->update($datosPropiedad);

        return redirect('propiedades_edit_geolocalizacion/'.$id);
    }
}
