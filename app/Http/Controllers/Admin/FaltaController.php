<?php 
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\AdminController;
use App\Http\Requests\Admin\FaltaRequest;
use App\Falta;
use App\User;
use Datatables;
use DateInterval;
use DateTime;
use DatePeriod;

class FaltaController extends AdminController {
    /*
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index()
    {
        $professores = User::select('users.id', 'users.name')->where('tipo_usuario', '=', 1)->get();

        // Show the page
        return view('admin.faltas.index', compact('professores', 'turmas'));
    }

    public function store(FaltaRequest $request)
    {

        if(strlen($request->aluno_id) == 0) {
            return redirect("/admin/faltas");
        }
        $idAlunosRequest = explode("|", $request->aluno_id);
        $dataFalta = strlen($request->data_falta) ==0 ? date('Y-m-d H:i:s') : $request->data_falta;
        $faltasInserts = Array();
        foreach($idAlunosRequest as $idAluno) {
            $dados = [
                'professor_id'  => $request->professor_id,
                'turma_id'      => $request->turmas_id,
                'materia_id'    => $request->materias_id,
                'aluno_id'      => $idAluno,
                'dia_falta'     => $dataFalta
            ];

            $faltasInserts[] = $dados;
        }

        if(count($faltasInserts) > 0) {
            Falta::insert($faltasInserts);
        }

      return redirect("/admin/faltas");
    }

    public function getFaltasTurma()
    {
        $date_begin = new DateTime('2015-07-08');
        $date_end = new DateTime('2015-12-31');
        // Definimos o intervalo de 1 ano
        $interval = new DateInterval('P1D');

        // Resgatamos datas de cada ano entre data de início e fim
        $period = new DatePeriod($date_begin, $interval, $date_end);
        $dados = [];
        $feriados = ['07-09', '16-09', '12-10', '02-11', '07-12', '08-12'];
        foreach($period as $key => $date) {
            if(!preg_match('(Fri|Sat|Sun)', $date->format("D")) && !in_array($date->format("d-m"), $feriados ))
            {
                $dados['dias'][] = $date->format("d-m");
            }
        }
        dd($dados['dias']);
        return view('admin.faltas.matriz', compact('dados'));
    }

}