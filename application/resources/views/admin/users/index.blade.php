@extends('adminlte::page')

@section('title', $title)

@section('content')
	@include('flash::message')
    <div class="panel panel-default">
    	<div class="panel-heading">
    		<h2>{{ $title }}</h2>
    	</div>
    	<div class="panel-body">
    		<a class="btn btn-success" href="{{ route('users.create') }}"><i class="fa fa-plus"></i> Nuevo Registro</a>
    		<br />
    		<br />
    		<table class="table table-bordered table-striped data-table">
    			<thead>
    				<th>ID</th>
    				<th>Nombre</th>
    				<th>Correo</th>
    				<th>Telefono</th>
    				<th>Tipo de Usuario</th>
    				<th>/</th>
    			</thead>
    			<tbody>
    				@foreach($record as $r)
    				<tr>
    					<td>{{ $r->id }}</td>
    					<td>{{ $r->name }}</td>
    					<td>{{ $r->email }}</td>
    					<td>{{ $r->phone }}</td>
    					<td>{{ $r->role }}</td>
    					<td>
    						<a href="{{ route('users.edit',['id' => $r->id]) }}" class="btn btn-info"><i class="fa fa-pencil"></i></a>
    						{!! Form::open(['route' => ['users.destroy',$r->id], 'method' => 'DELETE', 'style' => 'display:inline;']) !!}
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