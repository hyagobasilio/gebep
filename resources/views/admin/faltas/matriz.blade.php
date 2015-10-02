@extends('adminlte')


@section('heade')
    <link rel="stylesheet" href="{{ asset('/plugins/datepicker/datepicker3.css') }}">
@endsection
@section('content-header')
        <!-- You can dynamically generate breadcrumbs here -->
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Cadastro de Faltas</a></li>
    <li class="active">Principal - {{ count($dados['dias']) }}</li>
</ol>
@endsection
{{-- Content --}}
@section('content')
<br>
<div class="row">
    <div class="col-md-12">
    <table class="table">
        <thead>
            <tr>
                <th>Alu</th>
                @for($i = 0; $i < 38; $i++)
                <th>{{ isset($dados['dias'][$i]) ? $dados['dias'][$i] : '' }}</th>
                @endfor
            </tr>
        </thead>
        <tbody>

        </tbody>
    </table>

    </div><!-- /.col-md-12 -->
</div> <!-- /.row -->
@endsection

@section('scripts')
    <script src="{{ asset('bower_components/admin-lte/plugins/input-mask/jquery.inputmask.js') }}"></script>
    <script src="{{ asset('bower_components/admin-lte/plugins/input-mask/jquery.inputmask.date.extensions.js') }}"></script>
    <script src="{{ asset('bower_components/admin-lte/plugins/input-mask/jquery.inputmask.date.extensions.js') }}"></script>
    <script src="{{ asset('plugins/datepicker/bootstrap-datepicker.js') }}"></script>
    <script>


        $(document).ready(function(){
            var dias = JSON.parse("{' {{ implode(" /' , /' ",$dados['dias'])   }} '}");
            console.log(dias);
            $.ajax({
                dataType: "json",
                url: link,
                success: function(dados) {
                    $('#turmas_id').attr('disabled', false)
                    $.each( dados.turmas, function(index, value) {
                        $('<option>', {
                            value: value.id,
                            html: value.nome
                        }).appendTo('#turmas_id');
                    });
                }
            });
        });



    </script>
@endsection



