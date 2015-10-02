<?php 
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\AdminController;
use App\Http\Requests\Admin\AlunoTurmaRequest;
use App\Turma;
use App\User;
use App\AlunoTurma;
use Datatables;
use Illuminate\Support\Facades\DB;

class AlunoTurmaController extends AdminController {
    /*
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index()
    {
        $alunos = User::select('users.id', 'users.name')->where('tipo_usuario', '=', 0)->get();
        $turmas = Turma::select('turmas.id', 'turmas.nome')->get();

        // Show the page
        return view('admin.alunosturmas.index', compact('alunos', 'turmas'));
    }

    public function postCreate(AlunoTurmaRequest $request){
        $idalunosRequest = explode("|", $request->aluno_id);

        if(strlen($request->aluno_id) == 0) {
            AlunoTurma::where('turma_id', '=', $request->turma_id)->delete();
            return redirect("/admin/alunos-turma");
        }
        $alunos= array();
        $alunosDelete = array();
        $alunosDoBanco = AlunoTurma::select('aluno_turma.aluno_id')->where('turma_id','=',$request->turma_id)->get();

        foreach($alunosDoBanco as $banco) {
            if( !in_array($banco->aluno_id, $idalunosRequest) ) {
                array_push($alunosDelete,$banco->aluno_id);
            }else {
                array_push($alunos, $banco->aluno_id);
            }
        }

        if(count($alunosDelete) > 0) {
            AlunoTurma::whereIn('aluno_id', $alunosDelete)->where('turma_id', '=', $request->turma_id)->delete();
        }

        $idAlunos = array_diff($idalunosRequest, $alunos);

        $alunosInserts = [];
        if(count($alunos) == 0) {
            $idAlunos = $idalunosRequest;
        }
        foreach($idAlunos as $idAluno) {
            array_push($alunosInserts, ['aluno_id' => $idAluno, 'turma_id' => $request->turma_id]);
        }
        if(count($alunosInserts) > 0) {
            AlunoTurma::insert($alunosInserts);
        }



        return redirect("/admin/alunos-turma");
    }

    public function getAlunosRelacionados($idTurma) {


        $alunos = DB::table('users')->select('users.id', 'users.name as nome')
            ->join('aluno_turma', 'users.id', '=', 'aluno_turma.aluno_id')
            ->where('users.tipo_usuario', '=', 0)
            ->where('aluno_turma.turma_id', $idTurma)
            ->get();

        $dados['alunos'] = $alunos;

        return response()->json($dados);

    }

}