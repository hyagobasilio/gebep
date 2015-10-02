@extends('adminlte')
@section('content-header')
<h1>
    Matéria
    <small>visualização</small>
</h1>

<!-- You can dynamically generate breadcrumbs here -->
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Usuário</a></li>
    <li class="active">Visualização</li>
</ol>
@endsection
{{-- Content --}}
@section('content')
    <div class="row">
        <div class="col-md-12">
            
            <div class="pull-right">
                <a href="{{{ URL::to('admin/materias/create') }}}"
                   class="btn btn-sm  btn-primary iframe"><span
                            class="glyphicon glyphicon-plus-sign"></span> Nova Matéria</a>
            </div>
        </div>
    </div>
<br>
<div class="row">
    <div class="col_md_12">
        
        <table id="table" class="table table-striped table-hover">
            <thead>
            <tr>
                <th>Nome</th>
                <th>Ações</th>
            </tr>
            </thead>
            <tbody></tbody>
        </table>
    </div>
</div>
@endsection

{{-- Scripts --}}
@section('scripts')
    @parent
    <script type="text/javascript">
        
        var oTable;
        $(document).ready(function () {
            oTable = $('#table').DataTable({
                "sDom": "<'row'<'col-md-6'l><'col-md-6'f>r>t<'row'<'col-md-6'i><'col-md-6'p>>",
                "sPaginationType": "full_numbers",
                "processing": true,
                "serverSide": true,
                "ajax": "{{ URL::to('admin/materias/data/') }}",

            });
        });
  

        
    </script>
@endsection
