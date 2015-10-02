@extends('adminlte')
@section('content-header')


<!-- You can dynamically generate breadcrumbs here -->
<ol class="breadcrumb">
    <li><a href="#"><i class="fa fa-dashboard"></i> Relacionamento Professor / Matéria</a></li>
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
                <h3 class="box-title">Relacionamento Professor / Matéria</h3>
            </div><!-- /.box-header -->
            <!-- form start -->
            <form id="form-relacionamento-at" class="form-horizontal" method="post"
                  action="{{ URL::to('admin/professor-materias/create') }}"
                  autocomplete="off">
                <input type="hidden" name="_token" value="{{{ csrf_token() }}}" />
                <!-- box-body -->
                <div class="box-body">
                    <div class="col-xs-12">
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

                        <div class="col-xs-5">
                            <div class="form-group">
                                <label for="materias">Materias</label>
                                <select name="materias" size="10" id="materias" multiple="" class="height form-control">
                                    @foreach($materias as $materia)
                                    <option value="{{ $materia->id }}" > {{ $materia->nome }} </option>
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
                                <label for="materias_selecionadas">Matérias Relacionadas</label>
                                <select name="materias_selecionadas" size="10" id="materias_selecionadas" multiple="" class="height form-control">
                                </select>
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
                    <input type="hidden" id="idsMaterias" name="idsMaterias">
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

        function validaSelect(dados) {
            var select = $(dados.selector);

            if(select.val() == "") {

                select.parent().get(0).className = "form-group has-warning";

                return false;
            }
            return true;
        }

        $(document).ready(function(){
            var ids = "";
            $("#leftToRight").on('click',function(){
                $("#materias option:selected").each(function(i, item){
                    if(!contains(item.value, "#materias_selecionadas option")) {
                        $('<option>', {
                            value: item.value,
                            html: item.innerHTML
                        }).appendTo('#materias_selecionadas');
                    }

                });
            });
            jQuery("#rightToLeft").on('click', function(){
                var selecionados = $("#materias_selecionadas option:selected");
                    for(i = 0; i < selecionados.length; i++) {
                        selecionados[i].remove();
                    }
            });
            $("#submit").on('click',function(){
                ids = "";
                $("#materias_selecionadas option").each(function(i) {
                    if(i === $("#materias_selecionadas option").length -1) {
                        ids += this.value;
                    }else{

                        ids += (this.value + "|");
                    }
                });

                $("#idsMaterias").val(ids);
                if(validaSelect({selector: "#professor_id", mensagem: "Escolha um professor!"})) {

                    $("form").submit();
                }
            });

            $("#professor_id").on('change', function () {
                var idProfessor = this.value;
                $('#materias_selecionadas').empty();
                if(idProfessor != "") {
                    $.ajax({
                    dataType: "json",
                    url: "{{URL::to('admin/professor-materias/1/materias')}}".replace("1", idProfessor),
                    success: function(dados) {
                            $.each( dados.materias, function(index, value) {
                                $('<option>', {
                                    value: value.id,
                                    html: value.nome
                                }).appendTo('#materias_selecionadas');
                            });
                        }
                    });
                }

            });




         });



    </script>
@endsection



