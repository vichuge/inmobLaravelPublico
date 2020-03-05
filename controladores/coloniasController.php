<?php

namespace App\Http\Controllers;

use DB;
use App\Colonias;
use App\Imagenes;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class coloniasController extends Controller
{
    public function index()
    {
        //$datos['colonias'] = Colonias::get();
        $datos['colonias'] = DB::table('colonias')
            ->join('zonas', 'colonias.idzona','=','zonas.id')
            ->select(DB::raw('
                colonias.id,
                colonias.nomcolonia,
                colonias.descripcionesp,
                colonias.descripcioning,
                colonias.idzona,
                zonas.nomzona
            '))->get();
        return view('colonias.index', $datos);
    }

    public function create()
    {
        $datos['zonas']=DB::table('zonas')->get();
        return view('colonias.create',$datos);
    }

    public function store(Request $request)
    {
        //Campos para validación
        $campos = [
            'nomcolonia' => 'required|string|max:100',
            'descripcionesp' => 'required|string|max:700',
            'descripcioning' => 'max:700',
            'idzona'=>'required|int|max:2'
        ];
        //Mensaje para la validación
        $Mensaje = ["required" => ':attribute es requerido'];

        //Ejecutar la validación
        $this->validate($request, $campos, $Mensaje);


        // Para tomar los datos del formulario excepto el token
        $datosColonia = request()->except('_token');

        //Para insertar los datos en la bd
        //Colonias::insert($datosColonia);
        DB::table('colonias')->insert([$datosColonia]);
        $id = DB::getPdo()->lastInsertId();

        //Tomar los datos de la bd y anexarlos a la variable $datos['empleados']
        //$datos['colonias'] = Colonias::paginate(5);

        //imprimir la vista empleados.index anexandole la variable $datos
        //$id=Colonias::getPdo()->lastInsertId();
        return redirect('colonias_galeria/' . $id);
    }

    public function edit($id)
    {
        $datos['colonia'] = Colonias::findOrFail($id);
        $datos['zonas']=DB::table('zonas')->get();
        return view('colonias.edit', $datos);
    }

    public function update(Request $request, $id)
    {
        //Campos para validación
        $campos = [
            'nomcolonia' => 'required|string|max:100',
            'descripcionesp' => 'required|string|max:700',
            'descripcioning' => 'max:700',
            'idzona'=>'required|int|max:2'
        ];

        $Mensaje = ["required" => 'El :attribute es requerido'];

        $this->validate($request, $campos, $Mensaje);

        $datosEmpleado = request()->except('_token');

        Colonias::where('id', '=', $id)->update($datosEmpleado);

        $datos['colonias'] = Colonias::get();
        return redirect('colonias')->with('Mensaje', 'Amenidad modificada con éxito');
    }

    public function destroy($id)
    {
        $amenidad = Colonias::findOrFail($id);
        Colonias::destroy($id);
        return redirect('colonias')->with('Mensaje', 'Amenidad eliminada con éxito');
    }

    public function galeria($id)
    {
        $datos['colonia'] = Colonias::findOrFail($id);

        $match = ['idasignacion' => $id, 'asignacion' => 'colonia'];
        $datos['imagenes'] = Imagenes::where($match)->orderBy('principal', 'desc')->get();

        $matchP = ['idasignacion' => $id, 'asignacion' => 'colonia', 'principal' => '1'];
        $datos['imagenesP'] = Imagenes::where($matchP)->get();

        return view('colonias.galeria', $datos);
    }

    public function subir_img(Request $request, $id)
    {
        $campos = ['nomimagen' => 'required|max:10000|mimes:jpeg,png,jpg'];
        //Mensaje para la validación
        $Mensaje = ['required' => 'Es requerido cargar una imagen'];
        //Ejecutar la validación
        $this->validate($request, $campos, $Mensaje);
        $datosImg = request()->except('_token');
        if ($request->hasFile('nomimagen')) {

            $img = Colonias::findOrFail($id);
            $datosImg['nomimagen'] = $request->file('nomimagen')->store('uploads', 'public');
        }
        $datosImg += [
            'idasignacion' => $id,
            'asignacion' => 'colonia',
            'principal' => '0'
        ];
        Imagenes::insert($datosImg);

        //Asignar como principal solo si es la primera imagen insertada en esa colonia
        $match = ['idasignacion' => $id, 'asignacion' => 'colonia'];
        $numImagenes = count(Imagenes::where($match)->get());
        if ($numImagenes == 1) {
            Imagenes::where($match)->update(['principal' => '1']);
        }
        //print_r($match);
        //print_r($numImagenes);

        return redirect('colonias_galeria/' . $id);
    }

    public function elegir_principal(Request $request, $id)
    {
        $datosP = request()->except('_token');

        $idImagen = $datosP['optionsRadios'];
        //print_r($idImagen);

        $match = ['idasignacion' => $id, 'asignacion' => 'colonia', 'principal' => '1'];
        Imagenes::where($match)->update(['principal' => '0']);

        $match = ['id' => $idImagen, 'asignacion' => 'colonia', 'principal' => '0'];
        Imagenes::where($match)->update(['principal' => '1']);

        return redirect('colonias_galeria/' . $id);
    }

    public function elim_img($id)
    {
        //$match=['id'=>$id];
        $dataImage = Imagenes::findOrFail($id);

        if ($dataImage->principal == 1) {
            $match = ['asignacion' => 'colonia', 'principal' => '0', 'idasignacion' => $dataImage->idasignacion];
            //Imagenes::where($match)->update(['principal' => '1']);
            DB::table('imagenes')->where($match)->limit(1)->update(['principal'=>'1']);
        }

        if(Storage::delete('public/'.$dataImage->nomimagen)){
            Imagenes::destroy($id);
        }
        return redirect('colonias_galeria/' . $dataImage->idasignacion);
    }
}
