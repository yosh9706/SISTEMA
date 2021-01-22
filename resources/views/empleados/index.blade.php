
@extends('layouts.app')

@section('css')
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css">
@endsection

@section('content')

<div class="container">


@if(Session::has('Mensaje'))

<div class="alert alert-success" role="alert">
{{	Session::get('Mensaje')}}	
</div>
@endif


<a href="{{url('/empleados/create')}}" class="btn btn-success">Agregar empleado</a>
<br>
<br>
<table id="empleados1" class="table table-striped table-striped table-bordered table-hover shadow-lg mt-4">
	<thead class="bg-primary text-white">
		<tr>
			<th>#</th>
			<th>Foto</th>
			<th>Nombre</th>
			<th>Correo</th>
			<th>Acciones</th>
		</tr>
	</thead>

	<tbody>
	@foreach($empleados as $empleado)
		<tr>
			<td>{{$loop->iteration}}</td>
			<td>
				<!-- esto sirve para poder encontrar la imagen -->
				<!-- y hacemos un "php artisan storage:link" para que ya aparezca -->

				<img src="{{asset('storage').'/'.$empleado->Foto}}" class="img-thumbnail img-fluid" alt="" width="100">
			</td>
			<td>{{	$empleado->Nombre}} {{	$empleado->ApellidoPaterno}} {{	$empleado->ApellidoMaterno}}</td>
			<td>{{	$empleado->Correo}}</td>
			<td>

			<a class="btn btn-primary" href="{{url('/empleados/'.$empleado->id.'/edit')}}">
			Editar
			</a>

			<form method="post" action="{{url('/empleados/'.$empleado->id)}}" style="display: inline;">
			{{csrf_field()}}
			{{ method_field('DELETE')}}
			<button class="btn btn-danger" type="submit" onclick="return confirm('¿Borrar?')">Borrar</button>

			</form>
			</td>
		</tr>
	@endforeach
	</tbody>
</table>

</div>

@section('script')
<script src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>

<script >$(document).ready(function() {
    $('#empleados1').DataTable({
    	"lengthMenu":[[5,10,50,-1],[5,10,50,"All"]]
    });
} );
</script>

@endsection

@endsection
