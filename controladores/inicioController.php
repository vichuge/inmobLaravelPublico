<?php

namespace App\Http\Controllers;


use App\Propiedades;
use App\Prospectos;
use App\Agentes;
use DB;
use Illuminate\Http\Request;

class inicioController extends Controller
{
    //use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function index()
    {
        $datos['imagenes']=DB::table('imagenes')
            ->where('asignacion','=','propiedad')
            ->where('principal','=','1')
            ->get();
        $datos['propiedades']=Propiedades::get();

        //si esta en sesion entra aqui
        return view('inicio.index',$datos);
        //sino tiene session, regresa al login
        //return redirect('login/');
    }

    public function login()
    {
        //if(session('id')!=null){
            session()->forget('idrol');
            session()->forget('id');
            session()->forget('usuario');
            session()->forget('password');
            session()->forget('imagen');
            session()->forget('nomagente');
            session()->forget('apeagente');
        //}
        return view('inicio.login');
    }

    public function enter(Request $request)
    {
        $campos=[
            'email'=>'required|string|max:50',
            'password'=>'required|string|max:100'
        ];

        $datosAgente = request()->except('_token');
        //print_r($datosAgente);

        $Mensaje = ["required" => ':attribute es requerido'];
        //$this->validate($request, $campos, $Mensaje);

        $agente=DB::table('agentes')->where('email','=',$datosAgente['email'])->where('password','=',$datosAgente['password'])->get();
        /*if(!isset($agente[0])==null){
            //print_r('no es nulo');
        }else{
            //print_r('es nulo');
        }*/
        if(!isset($agente[0])==null)
        {
            //$_SESSION['idrol']=$agente[0]->idrol;
            //$_SESSION['id']=$agente[0]->id;
            //$_SESSION['usuario']=$agente[0]->email;
            //$_SESSION['password']=$agente[0]->password;
            //print_r($agente);
            $request->session()->put('idrol',$agente[0]->idrol);
            $request->session()->put('id',$agente[0]->id);
            $request->session()->put('usuario',$agente[0]->email);
            $request->session()->put('password',$agente[0]->password);
            $request->session()->put('imagen',$agente[0]->imagen);
            $request->session()->put('nomagente',$agente[0]->nomagente);
            $request->session()->put('apeagente',$agente[0]->apeagente);
            //print_r('si entro :)');
            return redirect('/');
        }else{ 
            //print_r('no entro :(');
            return redirect('/login');
        }
        
    }

    public function logout()
    {   
        return redirect('/login');
    }
    
    public function pruebas($venta,$renta,$tipo_listado,$precio_min,$precio_max)
    {
        if(($venta==0 && $renta==0) || ($venta==1 && $renta==1))
        {
            $condition_venta="";
            $condition_renta="";
        }elseif($venta==1){
            $condition_venta="venta=1";
            $condition_renta="";
        }elseif($renta==1){
            $condition_venta="";
            $condition_renta="renta=1";
        }

        if($tipo_listado=='0')
        {
            $condition_tipo="";
            //print_r('tipo_listado='.$tipo_listado);
        }else{
            $condition_tipo="tipo_listado='".$tipo_listado."'";
        }

        if($precio_min==0 && $precio_max==0){
            $condition_precio="";
        }elseif($precio_min==0 && $precio_max!=0){
            $condition_precio="(precio_venta<'".$precio_max."' OR precio_renta<'".$precio_max."')";
        }elseif($precio_min!=0 && $precio_max==0){
            $condition_precio="(precio_venta>'".$precio_min."' OR precio_renta>'".$precio_min."')";
        }elseif($precio_min!=0 && $precio_max!=0){
            $condition_precio="((precio_venta BETWEEN '".$precio_min."' AND '".$precio_max."') OR (precio_renta BETWEEN '".$precio_min."' AND '".$precio_max."'))";
        }else{
            print_r('Error!: Usted no deberia ver esto, favor de contactar al administrador');
        }

        $select=" * ";
        $table=" propiedades ";
        $id=1;
        $conditions="";
        //print_r("conditions=".$conditions);
        $contador=0;
        if($condition_venta!=null){
            $conditions=$conditions.$condition_venta;
            $contador++;
        }
        //print_r("conditions=".$conditions);
        if($condition_renta!=null){
            if($contador>0){
                $conditions=$conditions." AND ";
            }
            $conditions=$conditions.$condition_renta;
            $contador++;
        }
        //print_r("conditions=".$conditions);
        if($condition_tipo!=null){
            if($contador>0){
                $conditions=$conditions." AND ";
            }
            $conditions=$conditions.$condition_tipo;
            $contador++;
        }
        if($condition_precio!=null){
            if($contador>0){
                $conditions=$conditions." AND ";
            }
            $conditions=$conditions.$condition_precio;
            $contador++;
        }

        if($conditions!=null){
            //print_r('contidions!=null');
            $conditions=" WHERE ".$conditions;   
        }
        //print_r("conditions=".$conditions);
        $datos['propiedades']=DB::select('SELECT '.$select.' FROM '.$table.' '.$conditions);

        print_r('SELECT '.$select.' FROM '.$table.$conditions);

        //$venta,$renta,$tipo_listado,$precio_min,$precio_max
        $datos['venta']=$venta;
        $datos['renta']=$renta;
        $datos['tipo_listado']=$tipo_listado;
        $datos['precio_min']=$precio_min;
        $datos['precio_max']=$precio_max;

        //$datos['propiedades']=DB::table('propiedades')->get();
        return view('inicio.pruebas',$datos);
    }

    public function pruebas_buscar(Request $request)
    {
        //$venta,$renta,$tipo_listado,$precio_min,$precio_max
        $campos=[
            'venta'=>'max:1',
            'renta'=>'max:1',
            'precio_venta'=>'max:15',
            'precio_renta'=>'max:15',
            'tipo_listado'=>'max:10'
        ];

        $Mensaje = ["required" => ':attribute es requerido'];
        //$this->validate($request, $campos, $Mensaje);

        $datosPropiedad = request()->except('_token');

        if(isset($datosPropiedad['venta'])){
            $venta=$datosPropiedad['venta'];
        }else{
            $venta=0;
        }

        if(isset($datosPropiedad['renta'])){
            $renta=$datosPropiedad['renta'];
        }else{
            $renta=0;
        }

        if(isset($datosPropiedad['tipo_listado'])){
            $tipo_listado=$datosPropiedad['tipo_listado'];
        }else{
            $tipo_listado=0;
        }

        if(isset($datosPropiedad['precio_min'])){
            $precio_min=$datosPropiedad['precio_min'];
        }else{
            $precio_min=0;
        }

        if(isset($datosPropiedad['precio_max'])){
            $precio_max=$datosPropiedad['precio_max'];
        }else{
            $precio_max=0;
        }

        //$datos['propiedades']=DB::table('propiedades')->get();
        //return redirect('pruebas/'.$venta.'/'.$renta.'/'.$tipo_listado.'/'.$precio_min.'/'.$precio_max,$datos);
        return redirect('pruebas/'.$venta.'/'.$renta.'/'.$tipo_listado.'/'.$precio_min.'/'.$precio_max);

    }
}
