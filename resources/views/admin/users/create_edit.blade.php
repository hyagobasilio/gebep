{{-- @extends('adminlte') --}}
@section('content-header')
<h1>
    Usuário
    <small>{{ isset($user) ? "Editar" : "Cadastro" }}</small>
</h1>

<!-- You can dynamically generate breadcrumbs here -->
<ol class="breadcrumb">
    <li><a href="{{ URL::to('admin/users') }}"><i class="fa fa-dashboard"></i> Usuário</a></li>
    <li class="active">{{ isset($user) ? "Editar" : "Cadastro" }}</li>
</ol>
@endsection
@section('content')


		<div class="box box-info">
	        <div class="box-header with-border">
	          <h3 class="box-title">Cadastro de Usuário</h3>
	        </div><!-- /.box-header -->
	        <!-- form start -->
	        <form class="form-horizontal" method="post" enctype="multipart/form-data"
	action="@if (isset($user)){{ URL::to('admin/users/' . $user->id . '/edit') }}@endif"
	autocomplete="off">
			<input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
	          <div class="box-body">

				</div>
				  <div class="form-group {{{ $errors->has('image') ? 'error' : '' }}}">
					  <label for="name" class="col-sm-2 control-label">Foto</label>
					  <div class="col-sm-10">
						  {{{ $errors->first('image', "<label class=\"control-label\" for=\"inputError\"\> :message </label>") }}}
						  <input name="image"
								 type="file" class="uploader" id="image" value="Upload" />
					  </div>
				  </div>

	            <div class="form-group">
	              <label for="name" class="col-sm-2 control-label">Nome</label>
	              <div class="col-sm-10">
	                {{ $errors->first('name', "<label class=\"control-label\" for=\"inputError\"\> :message </label>")}}
	                <input type="text" name="name" class="form-control" id="name" placeholder="Nome" value="{{{ Input::old('name', isset($user) ? $user->name : null) }}}">
	              </div>
	            </div>
	            <div class="form-group">
	              <label for="username" class="col-sm-2 control-label">Username</label>
	              <div class="col-sm-10">
	                <input type="text" class="form-control" name="username" id="username" placeholder="Username" value="{{{ Input::old('username', isset($user) ? $user->username : null) }}}">
	                {{ $errors->first('username', '<label class="control-label"
                                                            for="username">:message</label>')}}
	              </div>
	            </div>
	            <div class="form-group">
	              <label for="email" class="col-sm-2 control-label">Email</label>
	              <div class="col-sm-10">
	                <input type="email" name="email" class="form-control" id="email" placeholder="Email" value="{{{ Input::old('email', isset($user) ? $user->email : null) }}}">
	                {{ $errors->first('email', '<label class="control-label"
                                                            for="email">:message</label>')}}
	              </div>
	            </div>

	            <div class="form-group">
	              <label for="password" class="col-sm-2 control-label">Senha</label>
	              <div class="col-sm-10">
	                <input type="password" name="password" class="form-control" id="password" placeholder="Senha">
	                {{ $errors->first('password', '<label class="control-label"
                                                            for="password">:message</label>')}}
	              </div>
	            </div>
	            <div class="form-group">
	              <label for="password_confirmation" class="col-sm-2 control-label">Confimar Senha</label>
	              <div class="col-sm-10">
	                <input type="password" class="form-control" name="password_confirmation" id="password_confirmation" placeholder="Senha" value="">
	                {{ $errors->first('password_confirmation', '<label class="control-label"
                                                            for="password_confirmation">:message</label>')}}
	              </div>
	            </div>

	            <?php $opcoes = ['Aluno' => 0, 'Professor' => 1, 'Gestor' => 2]; ?>
	            <div class="form-group">
	              <label for="tipo_usuario" class="col-sm-2 control-label">Tipo Usuário</label>
	              <div class="col-sm-10">
	                <select class="form-control" name="tipo_usuario" id="confirmed">
						@foreach($opcoes as $key => $value)
						<option value="{{ $value }}" @if(isset($user) && $user->tipo_usuario == $value)selected="true" @endif >{{ $key}}</option>
						@endforeach
					</select>
	              </div>
	            </div>

				{{--Cadastra usuário já ativo no sistema--}}
				<input type="hidden" name="confirmed" value="1">

	          </div><!-- /.box-body -->
	          <div class="box-footer">
	          	<a href="{{ URL::to('/admin/users') }}" class="btn btn-sm btn-danger close_popup">
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
