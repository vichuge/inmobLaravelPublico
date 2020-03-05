@extends('layouts.app')
@section('content')

@if(session('idrol')!='1')
<script>
    window.location = "{{URL::to('/')}}/login";
</script>
@endif

<ul class="user-info pull-left pull-none-xsm">
    <h1>Agentes</h1>
</ul>

<ul class="list-inline links-list pull-right">
    <li>
        <button onclick="window.location.href='{{url('agentes_create')}}'" type="button"
            class="btn btn-default">Nuevo agente</button>
    </li>
</ul>
<br />
<br />
<script type="text/javascript">
    jQuery(document).ready(function($) {
            var $table1 = jQuery('#table-1');

            // Initialize DataTable
            $table1.DataTable({
                "aLengthMenu": [
                    [10, 25, 50, -1],
                    [10, 25, 50, "All"]
                ],
                "bStateSave": true
            });

            // Initalize Select Dropdown after DataTables is created
            $table1.closest('.dataTables_wrapper').find('select').select2({
                minimumResultsForSearch: -1
            });
        });
</script>

<table class="table table-bordered datatable" id="table-1">
    <thead>
        <tr>
            <th>#</th>
            <th>Nombre</th>
            <th>Correo</th>
            <th>Tel. Celular</th>
            <th>Teléfono</th>
            <th>Departamento</th>
            <th>¿Usuario?</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($agentes as $agente)
        @if($agente->nomagente!=null)
        <tr class="gradeA">
            <td>{{$loop->iteration}}</td>
        <td>{{$agente->nomagente}} {{$agente->apeagente}}</td>
            <td>{{$agente->email}}</td>
            <td class="center">{{$agente->celular}}</td>
            <td class="center">{{$agente->telefono}}</td>
            <td class="center">{{$agente->dpto}}</td>
            <td class="center">{{$agente->idrol<=2? 'Si':'No'}}</td>
            <td align="center">
                <a href="{{url('agentes_edit/'.$agente->id)}}">
                    <i class="entypo-pencil"></i>
                </a>
                <a href="{{url('agentes_delete/'.$agente->id)}}">
                    <i class="entypo-cancel"></i>
                </a>
            </td>
        </tr>
        @endif
        @endforeach
    </tbody>
</table>

@endsection