@extends('layouts.app')
@section('content')

@if(session('idrol')!='1')
<script>
    window.location = "{{URL::to('/')}}/login";
</script>
@endif

<script type="text/javascript">
    function general(value) {
        console.log('general');
        document.getElementById("general").className="active";
        document.getElementById("usuarionav").className="";

        document.getElementById("generaldiv").style="display:block";
        document.getElementById("usuariodiv").style="display:none";
    }

    function agente(value){
        console.log('agente');
        document.getElementById("general").className="";
        document.getElementById("usuarionav").className="active";

        document.getElementById("generaldiv").style="display:none";
        document.getElementById("usuariodiv").style="display:block";
    }
</script>

<ul class="nav nav-tabs left-aligned" id="navbar" style="display:none">
    <!-- available classes "bordered", "right-aligned" -->
    
    <li class="active" id="general"><a onClick="general();">
            <span class="visible-xs"><i class="entypo-home"></i></span>
            <span class="hidden-xs">General</span>
        </a>
    </li>
    <li class="" id="usuarionav">
        <a onClick="agente();">
            <span class="visible-xs"><i class="entypo-user"></i></span>
            <span class="hidden-xs">Agente</span>
        </a>
    </li>

</ul>

<ul class="user-info pull-left pull-none-xsm">
    <h1>Nuevo agente</h1>
</ul>

<br /><br /><br /><br />
<!--<div class="panel-body">-->

<!-- Conteo e impresión de errores-->
<div class="row">
    <div class="col-md-12">
        @if(count($errors)>0)
        <div class="alert alert-danger" role="alert">
            <ul>
                @foreach($errors->all() as $error)
                <li>{{$error}}</li>
                @endforeach
            </ul>
        </div>
        @endif
    </div>
</div>

<div class="tab-content">

        <form action="{{url('agentes_store')}}" class="form-horizontal" method="post" enctype="multipart/form-data">
        {{csrf_field()}}
        @include('agentes.form',['Modo'=>'crear'])
    </form>
</div>
<br /><br /><br />
@endsection