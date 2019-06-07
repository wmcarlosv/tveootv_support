@extends('adminlte::page')

@section('title', $title)

@section('content')

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="panel panel-default">
    	<div class="panel-heading">
    		<h2>{{ $title }}</h2>
    	</div>
    	<div class="panel-body">
            @if($type == "new")
                {!! Form::open(['route' => 'users.store', 'method' => 'POST']) !!}
            @else
                {!! Form::open(['route' => ['users.update', @$record->id], 'method' => 'PUT']) !!}
            @endif
                <div class="form-group">
                    <label for="name">Nombre: </label>
                    <input type="text" class="form-control" value="{{ @$record->name }}" name="name" id="name">
                </div>
                <div class="form-group">
                    <label for="email">Correo: </label>
                    <input type="text" class="form-control" value="{{ @$record->email }}" name="email" id="email">
                </div>
                <div class="form-group">
                    <label for="phone">Telefono: </label>
                    <input type="text" class="form-control" value="{{ @$record->phone }}" name="phone" id="phone">
                </div>
                <div class="form-group">
                    <label for="role">Tipo: </label>
                    <select class="form-control" name="role" id="role">
                        <option>-</option>
                        <option value="administrator" @if(@$record->role == 'administrator') selected='selected' @endif>Administrador</option>
                        <option value="customer" @if(@$record->role == 'customer') selected='selected' @endif>Cliente</option>
                    </select>
                </div>
                @if($type == "new")
                <div class="input-group">
                    <input type="text" placeholder="Contraseña" name="password" readonly="readonly" id="password" class="form-control">
                    <div class="input-group-btn">
                        <button class="btn btn-success" id="generar_pass" type="button">Generar Clave</button>
                    </div>
                </div>
                @endif
                <br />
                <button class="btn btn-success"><i class="fa fa-floppy-o"></i> Guardar</button>
                <a class="btn btn-danger" href="{{ route('users.index') }}"><i class="fa fa-times"></i> Cancelar</a>
            {!! Form::close() !!}
    	</div>
    </div>
    @if($type == "update") 
        <div class="panel panel-default">
            <div class="panel-heading">
                <h2>Cambiar Contraseña</h2>
            </div>
            <div class="panel-body">
                {!! Form::open(['route' => ['user_change_password', $record->id], 'method' => 'PUT']) !!}
                    <div class="input-group">
                        <input type="text" placeholder="Contraseña" name="password" readonly="readonly" id="password" class="form-control">
                        <div class="input-group-btn">
                            <button class="btn btn-success" id="generar_pass" type="button">Generar Clave</button>
                        </div>
                    </div>
                    <br />
                    <button class="btn btn-success"><i class="fa fa-floppy-o"></i> Cambiar Contrase&ntilde;a</button>
                {!! Form::close() !!}
            </div>
        </div>
    @endif
@stop
@section('js')
<script type="text/javascript">
    $(document).ready(function(){
        $("#generar_pass").click(function(){
            var randomstring = Math.random().toString(36).slice(-8);
            $("#password").val(randomstring);
        });
    });

</script>
@stop