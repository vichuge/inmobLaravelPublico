<div class="row" id="generaldiv">
    <div class="col-md-6">

        <div class="form-group" {!! $errors->first('nomagente','has-error') !!} >
            <label class="col-sm-3 control-label" style="text-align:left">{{'Nombre*'}}</label>
            <br /><br />
            <div class="col-sm-9">
                <input type="text" class="form-control" name="nomagente"
                    value="{{isset($agente->nomagente)?$agente->nomagente:old('nomagente')}}">
                {!! $errors->first('nomagente','<p style="color:red">Campo requerido*</p>') !!}
            </div>
        </div>

        <div class="form-group" {!! $errors->first('apeagente','has-error') !!}>
            <label class="col-sm-3 control-label" style="text-align:left">{{'Apellido*'}}</label>
            <br /><br />
            <div class="col-sm-9">
                <input type="text" class="form-control" name="apeagente"
                    value="{{isset($agente->apeagente)?$agente->apeagente:old('apeagente')}}">
                {!! $errors->first('apeagente','<p style="color:red">Campo requerido*</p>') !!}
            </div>
        </div>

        <div class="form-group" {!! $errors->first('email','has-error') !!}>
            <label class="col-sm-3 control-label" style="text-align:left">{{'Email*'}}</label>
            <br /><br />
            <div class="col-sm-9">
                <input type="text" class="form-control" name="email"
                    value="{{isset($agente->email)?$agente->email:old('email')}}">
                {!! $errors->first('email','<p style="color:red">Campo requerido*</p>') !!}
            </div>
        </div>

        <div class="form-group col-md-12 {!! $errors->first('descripcionesp_agente','has-error') !!}">
            <label for="field-1" class="control-label" style="text-align:left">{{'Descripción en español'}}</label>
            <br /><br />
            <textarea class="form-control" style="resize:none;"
                name="descripcionesp_agente">{{isset($agente->descripcionesp_agente)?$agente->descripcionesp_agente:old('descripcionesp_agente')}}</textarea>
            {!! $errors->first('descripcionesp_agente','<p style="color:red">Campo requerido*</p>') !!}
        </div>

        <div class="form-group col-md-12 {!! $errors->first('descripcioning_agente','has-error') !!}">
            <label for="field-1" class="control-label" style="text-align:left">{{'Descripción en Inglés'}}</label>
            <br /><br />
            <textarea class="form-control" style="resize:none;"
                name="descripcioning_agente">{{isset($agente->descripcioning_agente)?$agente->descripcioning_agente:old('descripcioning_agente')}}</textarea>
            {!! $errors->first('descripcioning_agente','<p style="color:red">Campo requerido*</p>') !!}
        </div>


    </div>
    <div class="col-md-6">
        <div class="form-group" {!! $errors->first('celular','has-error') !!}>
            <label class="col-sm-3 control-label" style="text-align:left">{{'Tel. celular*'}}</label>
            <br /><br />
            <div class="col-sm-9">
                <input type="text" class="form-control" name="celular"
                    value="{{isset($agente->celular)?$agente->celular:old('celular')}}">
                {!! $errors->first('celular','<p style="color:red">Campo requerido*</p>') !!}
            </div>
        </div>

        <div class="form-group" {!! $errors->first('telefono','has-error') !!}>
            <label class="col-sm-3 control-label" style="text-align:left">{{'Teléfono'}}</label>
            <br /><br />
            <div class="col-sm-9">
                <input type="text" class="form-control" name="telefono"
                    value="{{isset($agente->telefono)?$agente->telefono:old('Dpto.')}}">
                {!! $errors->first('telefono','<p style="color:red">Campo requerido*</p>') !!}
            </div>
        </div>

        <div class="form-group" {!! $errors->first('dpto','has-error') !!}>
            <label class="col-sm-3 control-label" style="text-align:left">{{'dpto*'}}</label>
            <br /><br />
            <div class="col-sm-9">
                <input type="text" class="form-control" name="dpto"
                    value="{{isset($agente->dpto)?$agente->dpto:old('dpto')}}">
                {!! $errors->first('dpto','<p style="color:red">Campo requerido*</p>') !!}
            </div>
        </div>


        <script type="text/javascript">
            function habilitar(value) {
                    if (value == true) {
                        console.log('true');

                        document.getElementById("navbar").style="display:block";
                        document.getElementById("usuariodiv").style="display:none";
                    } else if (value == false) {
                        console.log('false');
                        // agentediv/buttons1

                        document.getElementById("usuario").value='';
                        document.getElementById("contrasena").value='';
                        document.getElementById("confirmar").value='';
                        
                        document.getElementById("navbar").style="display:none";
                        document.getElementById("usuariodiv").style="display:none";
                    }
                }
        </script>
        <div class="form-group">
            <div class="col-sm-10" align="center">
                <div class="checkbox checkbox-replace color-primary">
                    <input type="checkbox" id="check" onchange="habilitar(this.checked)" name="chkuser" value="on" {{isset($agente->idrol) && $agente->idrol<=2?'checked':''}}
                    >
                    <label>¿Será usuario del sistema?</label>
                </div>
            </div>
        </div>

        <div class="form-group">
            <label class="col-sm-9 control-label" style="text-align:left">Imagen</label>
            <br /><br />
            <div class="col-sm-10">
                <input type="file" class="form-control" id="field-file" name="imagen">
            </div>
            <br /><br /><br />
            <div class="col-sm-10" align="center">
                <img src="{{isset($agente->imagen)?asset('storage').'/'.$agente->imagen:asset('storage').'/uploads/'.'user.jpg'}}"  width="150">
            </div>
        </div>

    </div>
</div>

<div class="row" id="usuariodiv">
    <div class="col-md-6">

        <div class="form-group" {!! $errors->first('usuario','has-error') !!}>
            <label class="col-sm-12 control-label" style="text-align:left">{{'usuario*'}}</label>
            <br /><br />
            <div class="col-sm-9">
                <input type="text" class="form-control" name="usuario" id="usuario"
                    value="{{isset($agente->usuario)?$agente->usuario:old('usuario')}}">
                {!! $errors->first('usuario','<p style="color:red">Campo requerido*</p>') !!}
            </div>
        </div>

        <div class="form-group" {!! $errors->first('password','has-error') !!}>
            <label class="col-sm-3 control-label" style="text-align:left">{{'password*'}}</label>
            <br /><br />
            <div class="col-sm-9">
                <input type="text" class="form-control" name="password" id="contrasena"
                    value="{{isset($agente->password)?$agente->password:old('password')}}">
                {!! $errors->first('password','<p style="color:red">Campo requerido*</p>') !!}
            </div>
        </div>

        <div class="form-group" {!! $errors->first('confirmar','has-error') !!}>
            <label class="col-sm-3 control-label" style="text-align:left">{{'confirmar*'}}</label>
            <br /><br />
            <div class="col-sm-9">
                <input type="text" class="form-control" name="confirmar" id="confirmar"
                    value="{{isset($agente->password)?$agente->password:old('confirmar')}}">
                {!! $errors->first('confirmar','<p style="color:red">Campo requerido*</p>') !!}
            </div>
        </div>

    </div>
    <div class="col-md-6">
    </div>
</div>

<ul class="list-inline links-list pull-right">
    <li>
        <div class="form-group">
            <div class="col-sm-5">
                <button onclick="window.location.href=' {{url('/agentes')}}'" type="button"
                    class="btn btn-default">Regresar al listado</button>
            </div>
        </div>
    </li>
    <li>
        <div class="form-group">
            <div class="col-sm-5">
                <button type="submit"
                    class="btn btn-default">{{$Modo=='crear' ? 'Agregar y continuar':'Modificar'}}</button>
            </div>
        </div>
    </li>
</ul>