@extends('admin.layouts.modal') @section('content')
<form id="deleteForm" class="form-horizontal" method="post"
	action="@if (isset($turma)){{ URL::to('admin/tumas/' . $turma->id . '/delete') }}@endif"
	autocomplete="off">

	<input type="hidden" name="_token" value="{{{ csrf_token() }}}" /> <input
		type="hidden" name="id" value="{{ $turma->id }}" />
	<div class="form-group">
		<div class="controls">
			<p>{{ "admin/modal.delete_message" }}</p>
			<element class="btn btn-warning btn-sm close_popup">
			<span class="glyphicon glyphicon-ban-circle"></span>
			Cancelar</element>
			<button type="submit" class="btn btn-sm btn-danger">
				<span class="glyphicon glyphicon-trash"></span> Deletar
			</button>
		</div>
	</div>
</form>
@stop
