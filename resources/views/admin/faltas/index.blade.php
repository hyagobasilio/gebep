@extends('adminlte')


@section('heade')
    <link rel="stylesheet" href="{{ asset('/plugins/datepicker/datepicker3.css') }}">
@endsection
@section('content-header')
        <!-- You can dynamically generate breadcrumbs here -->
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Cadastro de Faltas</a></li>
    <li class="active">Principal</li>
</ol>
@endsection
{{-- Content --}}
@section('content')
<br>
<div class="row">
    <div class="col-md-12">

        <div class="box box-info ">
            <div class="box-header with-border">
                <h3 class="box-title">Cadastro de Faltas</h3>
            </div><!-- /.box-header -->
            <!-- form start -->
            <form id="form-relacionamento-at" class="form-horizontal" method="post"
                  action="{{ URL::to('admin/faltas/create') }}"
                  autocomplete="off">
                <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                <!-- box-body -->
                <div class="box-body">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="professor_id">Professor</label>
                                    <select name="professor_id"  id="professor_id" class="form-control">
                                        <option value="">Selecione</option>
                                        @foreach($professores as $professor)
                                            <option value="{{ $professor->id }}"> {{ $professor->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="turmas_id">Turmas</label>
                                    <select name="turmas_id" disabled="true"  id="turmas_id" class="form-control">
                                        <option value="">Selecione</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="materias_id">Matérias</label>
                                    <select name="materias_id" disabled="true" id="materias_id" class="form-control">
                                        <option value="">Selecione</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>Data da falta</label>
                                    <div class="input-group">
                                        <div class="input-group-addon">
                                            <i class="fa fa-calendar"></i>
                                        </div>
                                        <input id="data_falta" name="data_falta" type="text" class="form-control">
                                    </div><!-- /.input group -->
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-xs-5 ">
                                <div class="form-group">
                                    <label for="alunos">Alunos</label>
                                    <select name="alunos" size="10" id="alunos" multiple="" class="height form-control">
                                        <option value="" >  </option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-xs-2">
                                <label>Opções</label>
                                <button type="button" id="leftToRight" class="btn btn-block"><i class="glyphicon glyphicon-chevron-right"></i></button>
                                <button type="button" id="rightToLeft" class="btn btn-block"><i class="glyphicon glyphicon-chevron-left"></i></button>
                            </div>

                            <div class="col-xs-5">
                                <div class="form-group">
                                    <label for="alunos_falta">Alunos que faltaram</label>
                                    <select name="alunos_falta" size="10" id="alunos_falta" multiple="" class="height form-control">
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>
                </div><!-- /.box-body -->
                <div class="box-footer">
                    <a href="{{ URL::to('/') }}" class="btn btn-sm btn-danger close_popup">
                        <span class="glyphicon glyphicon-ban-circle"></span>
                        Cancelar
                    </a>
                    <button type="reset" class="btn btn-sm btn-default">
                        <span class="glyphicon glyphicon-remove-circle"></span>
                        Limpar
                    </button>
                    <!-- hidden -->
                    <input type="hidden" id="id_alunos" name="aluno_id">
                    <a href="#" id="submit" class="btn btn-info pull-right">
                        <span class="glyphicon glyphicon-ok-circle"></span>
                        Relacionar
                    </a>
                </div><!-- /.box-footer -->
            </form>
        </div>





    </div><!-- /.col-md-12 -->
</div> <!-- /.row -->
@endsection

@section('scripts')
    <script src="{{ asset('bower_components/admin-lte/plugins/input-mask/jquery.inputmask.js') }}"></script>
    <script src="{{ asset('bower_components/admin-lte/plugins/input-mask/jquery.inputmask.date.extensions.js') }}"></script>
    <script src="{{ asset('bower_components/admin-lte/plugins/input-mask/jquery.inputmask.date.extensions.js') }}"></script>
    <script src="{{ asset('plugins/datepicker/bootstrap-datepicker.js') }}"></script>
    <script>
        function contains(valor, selector) {
            lista = $(selector);
            for(i = 0; i < lista.length; i++) {
                if(lista[i].value == valor) {
                    return true;
                }
            }
            return false;
        }

        function validaSelect(dados) {
            var select = $(dados.selector);

            if(select.val() == "") {

                select.parent().get(0).className = "form-group has-warning";

                return false;
            }
            return true;
        }


        $(document).ready(function(){
            $("#data_falta").inputmask("dd/mm/yyyy");
            $("#data_falta").datepicker({
                format: 'dd/mm/yyyy',
                orientation: 'top'
            });
            var ids = "";
            $("#leftToRight").on('click',function(){
                $("#alunos option:selected").each(function(i, item){
                    if(!contains(item.value, "#alunos_falta option")) {
                        $('<option>', {
                            value: item.value,
                            html: item.innerHTML
                        }).appendTo('#alunos_falta');
                    }

                });
            });
            jQuery("#rightToLeft").on('click', function(){
                var selecionados = $("#alunos_falta option:selected");
                    for(i = 0; i < selecionados.length; i++) {
                        selecionados[i].remove();
                    }
            });
            $("#submit").on('click',function(){
                ids = "";
                $("#alunos_falta option").each(function(i) {
                    if(i === $("#alunos_falta option").length -1) {
                        ids += this.value;
                    }else{

                        ids += (this.value + "|");
                    }
                });
                $("#id_alunos").val(ids);
                if(
                        validaSelect({selector: "#professor_id", mensagem: "Selecione um professor!"}) &&
                        validaSelect({selector: "#turmas_id", mensagem: "Selecione uma Turma!"}) &&
                        validaSelect({selector: "#materias_id", mensagem: "Selecione uma Matéria!"})
                ) {

                    $("form").submit();
                }
            });
            // preenche o select de turmas com as turmas relacionadas com o professor
            $("#professor_id").on('change', function () {
                var idProfessor = this.value;
                $('#turmas_id').empty();
                $('<option>', {
                    value: '',
                    html: 'Selecione'
                }).appendTo('#turmas_id');
                if(idProfessor != "") {
                    var link = "{{URL::to('admin/professor-turmas/1/turmas')}}".replace("1", idProfessor);
                    console.log(link)
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
                }

            });

            $("#turmas_id").on('change', function () {
                var idProfessor = $('#professor_id').val();
                var idTurma = this.value;
                $('#materias_id').empty();
                $('<option>', {
                    value: '',
                    html: 'Selecione'
                }).appendTo('#materias_id');
                if(idTurma != "") {
                    // Pega materias relacionadas a turma e professor selecionados
                    $('#materias_id').attr('disabled', false);
                    $.ajax({
                        dataType: "json",
                        url: "{{URL::to('admin/materias/idProfessor/idTurma/materias')}}".replace("idProfessor", idProfessor).replace('idTurma', idTurma),
                        success: function(dados) {
                            $('#materias_id').empty();
                            $('<option>', {
                                value: '',
                                html: 'Selecione'
                            }).appendTo('#materias_id');
                            $.each( dados.turmas, function(index, value) {
                                $('<option>', {
                                    value: value.id,
                                    html: value.nome
                                }).appendTo('#materias_id');
                            });
                        }
                    });

                    // Pega os alunos relacionados a turma
                    $.ajax({
                        dataType: "json",
                        url: "{{URL::to('admin/alunos-turma/1/alunos')}}".replace("1", idTurma),
                        success: function(dados) {
                            $('#alunos').empty();
                            $.each( dados.alunos, function(index, value) {
                                $('<option>', {
                                    value: value.id,
                                    html: value.nome
                                }).appendTo('#alunos');
                            });
                        }
                    });



                }

            });




         });



    </script>
@endsection



