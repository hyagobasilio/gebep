@extends('adminlte')
@section('content-header')


<!-- You can dynamically generate breadcrumbs here -->
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Relacionamento Alunos / Turma</a></li>
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
                <h3 class="box-title">Relacionamento Alunos / Turma </h3>
            </div><!-- /.box-header -->
            <!-- form start -->
            <form id="form-relacionamento-at" class="form-horizontal" method="post"
                  action="{{ URL::to('admin/alunos-turma/create') }}"
                  autocomplete="off">
                <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                <!-- box-body -->
                <div class="box-body">
                    <div class="col-xs-12">
                        <div class="form-group">
                            <label for="turma_id">Turma</label>
                            <select name="turma_id"  id="turma_id" class="form-control">
                                <option value="">Selecione</option>
                            @foreach($turmas as $turma)
                                    <option value="{{ $turma->id }}"> {{ $turma->nome }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                        <div class="col-xs-5">
                            <div class="form-group">
                                <label for="basealunos">Alunos</label>
                                <select name="basealunos" size="10" id="basealunos" multiple="" class="height form-control">
                                    @foreach($alunos as $aluno)
                                    <option value="{{ $aluno->id }}" > {{ $aluno->name }} </option>
                                    @endforeach
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
                                <label for="alunos">Alunos Selecionados</label>
                                <select name="alunos" size="10" id="alunos" multiple="" class="height form-control">
                                </select>
                            </div>
                        </div>



                </div><!-- /.box-body -->
                <div class="box-footer">
                    <a href="{{ URL::to('/admin/turmas') }}" class="btn btn-sm btn-danger close_popup">
                        <span class="glyphicon glyphicon-ban-circle"></span>
                        Cancelar
                    </a>
                    <button type="reset" class="btn btn-sm btn-default">
                        <span class="glyphicon glyphicon-remove-circle"></span>
                        Limpar
                    </button>

                    <input type="hidden" id="aluno_id" name="aluno_id">
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

        $(document).ready(function(){
            var ids = "";
            $("#leftToRight").on('click',function(){
                $("#basealunos option:selected").each(function(i, item){
                    if(!contains(item.value, "#alunos option")) {
                        $('<option>', {
                            value: item.value,
                            html: item.innerHTML
                        }).appendTo('#alunos');
                    }

                });
            });
            jQuery("#rightToLeft").on('click', function(){
                var selecionados = $("#alunos option:selected");
                    for(i = 0; i < selecionados.length; i++) {
                        selecionados[i].remove();
                    }
            });
            $("#submit").on('click',function(){
                ids = "";
                $("#alunos option").each(function(i) {
                    if(i === $("#alunos option").length -1) {
                        ids += this.value;
                    }else{

                        ids += (this.value + "|");
                    }
                });

                 $("#aluno_id").val(ids);
                $("form").submit();
            });

            $("#turma_id").on('change', function () {
                var idTurma = this.value;
                $('#alunos').empty();
                if(idTurma != "") {
                    $.ajax({
                    dataType: "json",
                    url: "{{URL::to('admin/alunos-turma/1/alunos')}}".replace("1", idTurma),
                    success: function(dados) {
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



