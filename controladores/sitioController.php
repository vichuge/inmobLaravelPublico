<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Propiedades;
use App\Blogs;
use App\Faqs;
use App\Prospectos;
use App\Testimonios;
use App\Negocios;

class sitioController extends Controller
{
    public function index()
    {
        //$datos['imagenes']=DB::table('imagenes')->where('asignacion','=','propiedad')->where('principal','=','1')->get();
        //select id,nomimagen from imagenes where asignacion='propiedad' and principal=1 order by id desc limit 3;
        $datos['imagenes']=DB::select('select id,nomimagen from imagenes where asignacion="propiedad" and principal="1" order by id desc limit 3');
        $datos['zonas']=DB::table('zonas')->get();
        $datos['tipo_propiedad']=DB::table('tipo_propiedad')->get();
        $datos['blog']=DB::select('select * from blogs order by id desc limit 1');
        return view ('sitio.index',$datos);
        
    }

    public function about(){return view ('sitio.about');}
    public function privacy_notice(){return view ('sitio.privacy_notice');}
    public function terms_conditions(){return view ('sitio.terms_conditions');}
    
    public function zone_merida(){return view ('sitio.zone_merida');}

    public function contact($idpropiedad='')
    {
        //print_r($idpropiedad);
        $datos['propiedad']=$idpropiedad;
        return view('sitio.contact',$datos);
    }

    public function testimony()
    {
        $datos['testimonios']=Testimonios::get();
        return view ('sitio.testimony',$datos);
    }

    public function blog()
    {
        $datos['blogs']=Blogs::get();
        return view ('sitio.blog',$datos);
    }

    public function blog_detail($id)
    {
        $datos['blog']=Blogs::where('id','=',$id)->get();
        return view ('sitio.blog_detail',$datos);
    }

    

    public function faqs()
    {
        $datos['faqs']=Faqs::where('activa','=','1')->get();
        return view ('sitio.faqs',$datos);
    }

    public function property($venta,$renta,$idzona,$precio,$idtipo_propiedad,$numrecamaras,$numbanos,$idcolonia)
    {
        
        if(($venta==0 && $renta==0) || ($venta==1 && $renta==1))
        {
            $condition_venta="";
            $condition_renta="";

            if($precio==0){
                $condition_precio="";
            }
            elseif($precio>0 && $precio<= 1000000){
                $condition_precio=" precio_venta<= 1000000 ";
            }elseif($precio> 1000000 && $precio <=2000000){
                $condition_precio=" precio_venta BETWEEN 1000000 AND 2000000 ";
            }elseif($precio> 2000000 && $precio <=3000000){
                $condition_precio=" precio_venta BETWEEN 2000000 AND 3000000 ";
            }elseif($precio>3000000){
                $condition_precio=" precio_venta>3000000 ";
            }
        }elseif($venta==1){
            $condition_venta="venta=1";
            $condition_renta="";

            if($precio==0){
                $condition_precio="";
            }
            elseif($precio>0 && $precio<= 1000000){
                $condition_precio=" precio_venta<= 1000000 ";
            }elseif($precio> 1000000 && $precio <=2000000){
                $condition_precio=" precio_venta BETWEEN 1000000 AND 2000000 ";
            }elseif($precio> 2000000 && $precio <=3000000){
                $condition_precio=" precio_venta BETWEEN 2000000 AND 3000000 ";
            }elseif($precio>3000000){
                $condition_precio=" precio_venta>3000000 ";
            }
        }elseif($renta==1){
            $condition_venta="";
            $condition_renta="renta=1";

            if($precio==0){
                $condition_precio="";
            }
            elseif($precio>0 && $precio<= 1000000){
                $condition_precio=" precio_renta<= 1000000 ";
            }elseif($precio> 1000000 && $precio <=2000000){
                $condition_precio=" precio_renta BETWEEN 1000000 AND 2000000 ";
            }elseif($precio> 2000000 && $precio <=3000000){
                $condition_precio=" precio_renta BETWEEN 2000000 AND 3000000 ";
            }elseif($precio>3000000){
                $condition_precio=" precio_renta>3000000 ";
            }
        }

        if($idzona==0){
            $condition_zona="";
        }else{
            $condition_zona="c.idzona=".$idzona;
        }

        /*if($precio==0){
            $condition_precio="";
        }
        elseif($precio>0 && $precio<= 1000000){
            $condition_precio=" precio_venta<= 1000000 ";
        }elseif($precio> 1000000 && $precio <=2000000){
            $condition_precio=" precio_venta BETWEEN 1000000 AND 2000000 ";
        }elseif($precio> 2000000 && $precio <=3000000){
            $condition_precio=" precio_venta BETWEEN 2000000 AND 3000000 ";
        }elseif($precio>3000000){
            $condition_precio=" precio_venta>3000000 ";
        }*/

        if($idtipo_propiedad==0){
            $condition_tipo=0;
        }else{
            $condition_tipo="idtipo_propiedad=".$idtipo_propiedad;
        }

        if($numrecamaras==0){
            $condition_recamaras="";
        }else{
            if($numrecamaras>=4){
                $condition_recamaras="num_recamaras>=4";
            }else{
                $condition_recamaras="num_recamaras=".$numrecamaras;
            }
            
        }

        if($numbanos==0){
            $condition_banos="";
        }else{
            if($numbanos>=4){
                $condition_banos="num_banos>=4";
            }else{
                $condition_banos="num_banos=".$numbanos;
            }
        }

        if($idcolonia==0){
            $condition_colonias="";
        }else{
            $condition_colonias="c.id=".$idcolonia;
        }

        /*
        SELECT
            a.id,
            (select nomimagen from imagenes where idasignacion=a.id and principal='1') imagen, 
            a.nompropiedadesp, 
            a.num_recamaras, 
            a.num_banos, 
            a.num_estacionamiento, 
            a.construccion, 
            a.precio_venta,
            a.idcolonia,
            colonias.idzona,
            zonas.nomzona
        FROM propiedades
        JOIN colonias on colonias.id=a.idcolonia
        JOIN zonas on colonias.idzona=zonas.id
        WHERE colonias.idzona=1
        ;
        */
        $select="
            a.id,
            (select nomimagen from imagenes where idasignacion=a.id and principal='1') imagen, 
            a.nompropiedadesp, 
            a.num_recamaras, 
            a.num_banos, 
            a.num_estacionamiento, 
            a.construccion, 
            a.precio_venta,
            a.precio_renta,
            a.idcolonia,
            a.venta,
            a.renta,
            a.idmoneda_venta,
            a.idmoneda_renta,
            c.idzona,
            d.nomzona,
            e.nomunidad,
            b.nommedida,
            (select moneda from monedas where id=a.idmoneda_renta) moneda_renta,
            (select moneda from monedas where id=a.idmoneda_venta) moneda_venta
        ";
        $table=" propiedades a ";
        $id=1;
        $conditions="";
        //print_r("conditions=".$conditions);
        $contador=0;
        //condition_venta condition_renta condition_zona condition_precio condition_tipo condition_recamaras condition_banos
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
        if($condition_zona!=null){
            if($contador>0){
                $conditions=$conditions." AND ";
            }
            $conditions=$conditions.$condition_zona;
            $contador++;
        }
        if($condition_precio!=null){
            if($contador>0){
                $conditions=$conditions." AND ";
            }
            $conditions=$conditions.$condition_precio;
            $contador++;
        }
        if($condition_tipo!=null){
            if($contador>0){
                $conditions=$conditions." AND ";
            }
            $conditions=$conditions.$condition_tipo;
            $contador++;
        }
        if($condition_recamaras!=null){
            if($contador>0){
                $conditions=$conditions." AND ";
            }
            $conditions=$conditions.$condition_recamaras;
            $contador++;
        }
        if($condition_banos!=null){
            if($contador>0){
                $conditions=$conditions." AND ";
            }
            $conditions=$conditions.$condition_banos;
            $contador++;
        }
        if($condition_colonias!=null){
            if($contador>0){
                $conditions=$conditions." AND ";
            }
            $conditions=$conditions.$condition_colonias;
            $contador++;
        }

        if($conditions!=null){
            //print_r('contidions!=null');
            $conditions=" WHERE ".$conditions;
        }
        //print_r("conditions=".$conditions);
        
        /*
        JOIN colonias on colonias.id=a.idcolonia
        JOIN zonas on colonias.idzona=zonas.id
        WHERE colonias.idzona=1
        */
        $joins="
        JOIN medidas b on a.id_m_construccion=b.id
        JOIN colonias c on c.id=a.idcolonia 
        JOIN zonas d on c.idzona=d.id 
        JOIN unidades e on a.idunidad_renta=e.id

        
        "; 
        //print_r('SELECT '.$select.' FROM '.$table.' '.$joins.' '.$conditions);

        $datos['propiedades']=DB::select('SELECT '.$select.' FROM '.$table.' '.$joins.' '.$conditions);

        //$venta,$renta,$idzona,$precio,$idtipo_propiedad,$numrecamaras,$numbanos
        $datos['venta']=$venta;
        $datos['renta']=$renta;
        $datos['idzona']=$idzona;
        $datos['precio']=$precio;
        $datos['idtipo_propiedad']=$idtipo_propiedad;
        $datos['numrecamaras']=$numrecamaras;
        $datos['numbanos']=$numbanos;
        $datos['idcolonia']=$idcolonia;


        $datos['tipos_propiedades']=DB::table('tipo_propiedad')->get();
        $datos['zonas']=DB::table('zonas')->get();
        $datos['colonias']=DB::table('colonias')->get();
        $datos['monedas']=DB::table('monedas')->get();
        return view ('sitio.property',$datos);
    }

    public function property_details($id)
    {
        $datos['equipamentos']=DB::select('
        select a.id,a.nomamenidadesp 
        from amenidades a
        join propiedadesxamenidades b on a.id=b.idamenidad
        join propiedades c on c.id=b.idpropiedad
        where c.id='.$id);
        //$datos['propiedad']=Propiedades::where('id','=',$id)->get();
        $datos['propiedad']=DB::select('
        select
        a.id,
        a.nompropiedadesp,
        a.nompropiedading,
        a.descripcionesp,
        a.descripcioning,
        a.notas,
        a.venta,
        a.renta,
        a.precio_venta,
        a.precio_renta,
        a.termycond,
        a.fechaingreso,
        a.tipo_listado,
        a.marca_agua,
        a.nompropietario,
        a.apepropietario,
        a.direccionpropietario,
        a.notaspropietario,
        a.telpropietario,
        a.emailpropietario,
        a.superficie,
        a.frente,
        a.fondo,
        a.construccion,
        a.num_recamaras,
        a.num_banos,
        a.num_estacionamiento,
        a.ruta_video,
        a.latitud,
        a.longitud,

        b.nommedida,
        (select moneda from monedas where id=a.idmoneda_renta) moneda_renta,
        (select moneda from monedas where id=a.idmoneda_venta) moneda_venta
        
        from propiedades a
        JOIN medidas b on a.id_m_construccion=b.id
        where a.id='.$id
        );

        $datos['imagenes']=DB::select('
        select
        a.id,
        a.nomimagen,
        a.principal
        from imagenes a
        where asignacion="propiedad"
        and a.principal !="1"
        and a.idasignacion='.$id
        );

        $datos['img_principal']=DB::select('
        select
        a.id,
        a.nomimagen,
        a.principal
        from imagenes a
        where asignacion="propiedad"
        and a.principal ="1"
        and a.idasignacion='.$id
        );

        $datos['negocios']=Negocios::get();
        return view ('sitio.property_details',$datos);
    }

    

    public function indexproperty(Request $request)
    {
        $campos=[
            'idzona'=>'required|int|max:10',
            'idtipo_propiedad'=>'required|int|max:10',
            'operacion'=>'required|string|max:10'
        ];

        $Mensaje = ["required" => ':attribute es requerido'];
        $this->validate($request, $campos, $Mensaje);

        $datosPropiedad = request()->except('_token');

        //print_r($datosPropiedad);
        if($datosPropiedad['idzona']!=0){
            $idzona=$datosPropiedad['idzona'];
        }else{
            $idzona=0;
        }

        if($datosPropiedad['idtipo_propiedad']!=0){
            $idtipo_propiedad=$datosPropiedad['idtipo_propiedad'];
        }else{
            $idtipo_propiedad=0;
        }

        if($datosPropiedad['operacion']!='ninguna' && $datosPropiedad['operacion']!='ambos'){
            if($datosPropiedad['operacion']=="renta"){
                $venta=0;
                $renta=1;
            }elseif($datosPropiedad['operacion']=="venta"){
                $venta=1;
                $renta=0;
            }else{
                print_r('Usted no deberia ver esto y se ha notificado. Contacte a un administrador');
            }
        }else{
            $venta=0;
            $renta=0;
        }
        //$datos['propiedades']=DB::table('propiedades')->get();
        //return redirect('pruebas/'.$venta.'/'.$renta.'/'.$tipo_listado.'/'.$precio_min.'/'.$precio_max,$datos);
        return redirect('property/'.$venta.'/'.$renta.'/'.$idzona.'/0/'.$idtipo_propiedad.'/0/0/0');
    }

    public function sendinfo(Request $request)
    {
        $campos=[
            'nomprospecto'=>'required|string|max:50',
            'emailprospecto'=>'required|string|max:50',
            'telprospecto'=>'required|string|max:20',
            'desc_prospecto'=>'required|string|max:500'
        ];

        $Mensaje = ["required" => ':attribute es requerido'];
        //$this->validate($request, $campos, $Mensaje);

        $datosProspecto = request()->except('_token');
        $fecha=date("Y-m-d");
        $datosProspecto['fecha']=$fecha;
        //$datosProspecto['idpropiedad']=1;
        
        //print_r($datosProspecto);
        Prospectos::insert($datosProspecto);

        return redirect('contact/');
    }

    public function pruebas(){
        return view('sitio.property_details2');
    }

}
