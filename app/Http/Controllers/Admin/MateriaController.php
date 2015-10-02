<?php 
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\AdminController;
use App\Materia;
use App\Http\Requests\Admin\MateriaEditRequest;
use App\Http\Requests\Admin\MateriaRequest;
use App\Http\Requests\Admin\DeleteRequest;
use Datatables;
use Illuminate\Support\Facades\DB;

class MateriaController extends AdminController {
    /*
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index()
    {
        // Show the page
        return view('admin.materias.index');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function getCreate() {
        return view('admin.materias.create_edit');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function postCreate(MateriaRequest $request) {

        $materia = new Materia();
        $materia->nome = $request->nome;

        if($materia->save()) {
            return redirect("/admin/materias");
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param $materia
     * @return Response
     */
    public function getEdit($id) {
        $materia = Materia::find($id);
        return view('admin.materias.create_edit', compact('materia'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param $materia
     * @return Response
     */
    public function postEdit(MateriaEditRequest $request, $id) {
        $materia = Materia::find($id);
        $materia->nome = $request->nome;

        if($materia->save()) {
            return redirect("/admin/materias/$id/edit");
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param $materia
     * @return Response
     */
    public function getDelete($id)
    {
        $materia = Materia::find($id);
        // Show the page
        return view('admin.materias.delete', compact('user'));
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param $materia
     * @return Response
     */
    public function postDelete(DeleteRequest $request,$id)
    {
        $materia= Materia::find($id);
        $materia->delete();
    }
    /**
     * Show a list of all the languages posts formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function data()
    {
        $materias = Materia::select(array('materias.id','materias.nome'));
        return Datatables::of($materias)
            ->add_column('actions', '<a href="{{{ URL::to(\'admin/materias/\' . $id . \'/edit\' ) }}}" class="btn btn-success btn-sm iframe" ><span class="glyphicon glyphicon-pencil"></span>  Editar</a>
                    <a href="{{{ URL::to(\'admin/materias/\' . $id . \'/delete\' ) }}}" class="btn btn-sm btn-danger iframe"><span class="glyphicon glyphicon-trash"></span> Delete</a>
               ')
            ->remove_column('id')
            ->make();
    }

    public function getMateriasProfessorTurma($idProfessor, $idTurma)
    {
        $materias = DB::table('materias')
            ->select('materias.id', 'materias.nome')
            ->join('professor_materia', 'professor_materia.materia_id', '=', 'materias.id')
            ->join('materia_turma', 'materia_turma.materia_id', '=', 'professor_materia.materia_id')
            ->where('professor_materia.professor_id', '=', $idProfessor)
            ->where('materia_turma.turma_id', '=', $idTurma)
            ->get();

        $dados['turmas'] = $materias;

        return response()->json($dados);

    }
}