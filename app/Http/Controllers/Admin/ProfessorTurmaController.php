<?php 
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\AdminController;
use App\Http\Requests\Admin\ProfessorTurmaRequest;
use App\ProfessorTurma;
use App\Turma;
use App\User;
use Datatables;
use Illuminate\Support\Facades\DB;

class ProfessorTurmaController extends AdminController {
    /*
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index()
    {
        $professores = User::select('users.id', 'users.name')->where('tipo_usuario', '=', 1)->get();
        $turmas = Turma::all();

        // Show the page
        return view('admin.professorturmas.index', compact('professores', 'turmas'));
    }
    public function postCreate(ProfessorTurmaRequest $request)
    {
        $idTurmasRequest = explode("|", $request->idsMaterias);

        if(strlen($request->idsMaterias) == 0 ) {
            // Se vier vazio entao deleta todos os registro deste professor
            DB::table('professor_turma')->where('professor_id', $request->professor_id)->delete();
            return redirect("/admin/professor-turmas");
        }

        // Seleciona todos os relacionamentos
        $inserts = array();
        $turmas = ProfessorTurma::select('professor_turma.turma_id')->where('professor_id','=', $request->professor_id)->get();
        $turmasDelete= array();
        foreach($turmas as $banco) {
            if( !in_array($banco->turma_id, $idTurmasRequest) ) { // Verifica se o item nao está na nova lista
                $turmasDelete[] = $banco->turma_id; // Insere o id para ser inserido
            }else {
                $inserts[] = $banco->turma_id;      //novos que serao inseridos;
            }
        }

        if(count($turmasDelete) > 0) {
            ProfessorTurma::whereIn('turma_id', $turmasDelete)->where('professor_id', '=', (int)$request->professor_id)->delete();
        }

        $idTurmas = array_diff($idTurmasRequest, $inserts);
        $turmasInserts = [];

        if(count($inserts) == 0)
            $idTurmas = $idTurmasRequest;

        foreach($idTurmas as $idTurma) {
            $turmasInserts[] = ['turma_id' => $idTurma, 'professor_id' => $request->professor_id];

        }
        if(!empty($turmasInserts))
            ProfessorTurma::insert($turmasInserts);


        return redirect("/admin/professor-turmas");
    }

    public function getTurmasRelacionadas($idProfessor) {
        $alunos = DB::table('turmas')->select('turmas.id', 'turmas.nome')
            ->join('professor_turma', 'professor_turma.turma_id', '=', 'turmas.id')
            ->where('professor_turma.professor_id' , '=', $idProfessor)

            ->get();
        $dados['turmas'] = $alunos;

        return response()->json($dados);

    }

}