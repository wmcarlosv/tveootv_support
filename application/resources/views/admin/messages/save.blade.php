@extends('adminlte::page')

@section('title', $title)

@section('css')
<link href="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/css/select2.min.css" rel="stylesheet" />
@stop

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
                {!! Form::open(['route' => 'messages.store', 'method' => 'POST', 'files' => true]) !!}
            @else
                {!! Form::open(['route' => ['messages.update', @$record->id], 'method' => 'PUT', 'files' => true]) !!}
            @endif
            <div class="form-group">
                <label for="title">Titulo: </label>
                <input type="text" class="form-control" value="{{ @$record->title }}" name="title" id="title">
            </div>
            <div class="form-group">
                <label for="customers">Clientes: </label>
                <select class="form-control select-multiple" name="customers[]" id="customers" multiple="multiple">
                    @foreach($customers as $c)
                        <option value="{{ $c->id }}">{{ $c->name.' '.$c->email }}</option>
                    @endforeach
                </select>
            </div>
            @if($type == "update")
                @if(isset($record->cover) and !empty($record->cover))
                    <div class="content-image">
                        <img src="{{ asset('application/storage/app/'.$record->cover) }}" class="img-thumbnail" width="150" height="150">
                        <button type="button" class="btn btn-danger" id="delete-image"><i class="fa fa-times"></i></button>
                    </div>
                    <div class="form-group" style="display:none;" id="hide-file">
                        <label for="cover">Portada: </label>
                        <input type="file" class="form-control" name="cover" id="cover">
                    </div>
                @else
                    <div class="form-group">
                        <label for="cover">Portada: </label>
                        <input type="file" class="form-control" name="cover" id="cover">
                    </div>
                @endif
            @else
                <div class="form-group">
                    <label for="cover">Portada: </label>
                    <input type="file" class="form-control" name="cover" id="cover">
                </div>
            @endif
            
            <div class="form-group">
                <label for="description">Breve Descripci&oacute;n: </label>
                <textarea class="form-control" name="description" id="description">{{ @$record->description }}</textarea>
            </div>
            <div class="form-group">
                <label for="content">Contenido: </label>
                <textarea class="form-control" name="content" id="content">{{ @$record->content }}</textarea>
            </div>
            <button class="btn btn-success"><i class="fa fa-floppy-o"></i> Guardar</button>
            <a class="btn btn-danger" href="{{ route('messages.index') }}"><i class="fa fa-times"></i> Cancelar</a>
            {!! Form::close() !!}
    	</div>
    </div>
@stop
@section('js')
<script src="http://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.12/summernote.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.7/js/select2.min.js"></script>
<script type="text/javascript">
    $(document).ready(function(){

        $("#content").summernote({
            'height' : 400
        });

        $('.select-multiple').select2();

        $("#delete-image").click(function(){
            if(!confirm("Estas seguro de eliminar esta imagen?")){
                return false;
            }else{
                $.get("{{ route('messages.show',['id' => @$record->id]) }}", function( response ){
                    var data = JSON.parse(response);
                    if(data.deleted == "yes"){
                        alert("Imagen eliminada con Exito!!");
                        $("#content-image").hide();
                        $("#hide-file").show();
                    }
                });
            }
        });
    });
</script>
@stop