@extends('adminlte::page')

@section('title', $title)

@section('content')
	@include('flash::message')
    <div class="panel panel-default">
    	<div class="panel-heading">
    		<h2>{{ $title }}</h2>
    	</div>
    	<div class="panel-body">
    		<a class="btn btn-success" href="{{ route('messages.create') }}"><i class="fa fa-plus"></i> Nuevo Registro</a>
    		<br />
    		<br />
    		<table class="table table-bordered table-striped data-table">
    			<thead>
    				<th>ID</th>
    				<th>Titulo</th>
    				<th>Breve Descripci&oacute;n</th>
                    <th>Imagen</th>
    				<th>/</th>
    			</thead>
    			<tbody>
    				@foreach($record as $r)
    				<tr>
    					<td>{{ $r->id }}</td>
    					<td>{{ $r->title }}</td>
    					<td>{{ $r->description }}</td>
                        <td>
                            @if(isset($r->cover) and !empty($r->cover))
                                <img src="{{ asset('application/storage/app/'.$r->cover) }}" class="img-thumbnail" width="150" height="150">
                            @else
                                <center>Sin Imagen</center>
                            @endif
                        </td>
    					<td>
    						<a href="{{ route('messages.edit',['id' => $r->id]) }}" class="btn btn-info"><i class="fa fa-pencil"></i></a>
    						{!! Form::open(['route' => ['messages.destroy',$r->id], 'method' => 'DELETE', 'style' => 'display:inline;']) !!}
    							<button type="submit" class="btn btn-danger delete-record"><i class="fa fa-times"></i></button>
    						{!! Form::close() !!}
    					</td>
    				</tr>
    				@endforeach
    			</tbody>
    		</table>
    	</div>
    </div>
@stop
@section('js')
<script type="text/javascript">
	$(document).ready(function(){
		$("table.data-table").DataTable();
		$('div.alert').not('.alert-important').delay(3000).fadeOut(350);
		$("body").on('click','button.delete-record',function(){
			if(!confirm("Estas seguro de eliminar este Registro?")){
				return false;
			}
		});
	});
</script>
@stop