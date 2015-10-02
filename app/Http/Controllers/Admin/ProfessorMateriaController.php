<?php 
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\AdminController;
use App\Http\Requests\Admin\ProfessorMateriaRequest;
use App\ProfessorMateria;
use App\Materia;
use App\User;
use Datatables;
use Illuminate\Support\Facades\DB;

class ProfessorMateriaController extends AdminController {
    /*
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index()
    {
        $professores = User::select('users.id', 'users.name')->where('tipo_usuario', '=', 1)->get();
        $materias = Materia::all();

        // Show the page
        return view('admin.professormaterias.index', compact('professores', 'materias'));
    }
    public function postCreate(ProfessorMateriaRequest $request){
        $idMateriasRequest = explode("|", $request->idsMaterias);
        $inserts = [];
        if(strlen($request->idsMaterias) == 0) {
            ProfessorMateria::where('professor_id', '=', (int)$request->professor_id)->delete();
            return redirect("/admin/professor-materias");
        }
        $materias = ProfessorMateria::select('professor_materia.materia_id')->where('professor_id','=', $request->professor_id)->get();
        $materiasDelete= array();
        foreach($materias as $banco) {
            if( !in_array($banco->materia_id, $idMateriasRequest) ) {
                $materiasDelete[] = $banco->materia_id;
            }else {
                $inserts[] = $banco->materia_id;
            }
        }
        if(count($materiasDelete) > 0) {
            ProfessorMateria::whereIn('materia_id', $materiasDelete)->where('professor_id', '=', (int)$request->professor_id)->delete();
        }
        $idMaterias = array_diff($idMateriasRequest, $inserts);

        $materiasInserts = [];
        if(empty($inserts))
            $inserts = $idMateriasRequest;

        foreach($idMaterias as $idMateria) {
            $materiasInserts[] = ['materia_id' => $idMateria, 'professor_id' => $request->professor_id];
        }
        if(!empty($inserts))
            ProfessorMateria::insert($materiasInserts);


        return redirect("/admin/professor-materias");
    }

    public function getMateriasRelacionadas($idProfessor) {
        $dados['materias'] = DB::select(" SELECT m.id, m.nome FROM professor_materia pm, materias m WHERE
                                          pm.materia_id = m.id AND pm.professor_id = $idProfessor");

        return response()->json($dados);

    }

}