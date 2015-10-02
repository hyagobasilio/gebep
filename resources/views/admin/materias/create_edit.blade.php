{{-- @extends('adminlte') --}}
@section('content-header')
<h1>
    Matéria
    <small>{{ isset($user) ? "Editar" : "Cadastro" }}</small>
</h1>

<!-- You can dynamically generate breadcrumbs here -->
<ol class="breadcrumb">
    <li><a href="{{ URL::to('admin/materias') }}"><i class="fa fa-dashboard"></i> Matéria</a></li>
    <li class="active">{{ isset($materia) ? "Editar" : "Cadastro" }}</li>
</ol>
@endsection
@section('content')


		<div class="box box-info">
	        <div class="box-header with-border">
	          <h3 class="box-title">Cadastro de Matéria / Unidade Curricular</h3>
	        </div><!-- /.box-header -->
	        <!-- form start -->
	        <form class="form-horizontal" method="post" enctype="multipart/form-data"
	action="@if (isset($user)){{ URL::to('admin/users/' . $materia->id . '/edit') }}@endif"
	autocomplete="off">
			<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
	          <div class="box-body">



	            <div class="form-group">
	              <label for="nome" class="col-sm-2 control-label">Nome</label>
	              <div class="col-sm-10">
	                {{ $errors->first('name', "<label class=\"control-label\" for=\"inputError\"\> :message </label>")}}
	                <input type="text" name="nome" class="form-control" id="nome" placeholder="Nome" value="{{{ Input::old('nome', isset($materia) ? $materia->nome : null) }}}">
	              </div>
	            </div>


	          </div><!-- /.box-body -->
	          <div class="box-footer">
	          	<a href="{{ URL::to('/admin/materias') }}" class="btn btn-sm btn-danger close_popup">
					<span class="glyphicon glyphicon-ban-circle"></span> 
					Cancelar
				</a>
				<button type="reset" class="btn btn-sm btn-default">
					<span class="glyphicon glyphicon-remove-circle"></span> 
					Limpar
				</button>

	            <button type="submit" class="btn btn-info pull-right">
					<span class="glyphicon glyphicon-ok-circle"></span> 
					    @if	(isset($user))
					        Editar
					    @else
					        Criar
					    @endif
				</button>
	          </div><!-- /.box-footer -->
	        </form>
	      </div><!-- /.box -->

@stop
