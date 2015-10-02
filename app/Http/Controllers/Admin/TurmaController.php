<?php 
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\AdminController;
use App\Turma;
use App\Http\Requests\Admin\TurmaEditRequest;
use App\Http\Requests\Admin\TurmaRequest;
use App\Http\Requests\Admin\DeleteRequest;
use Datatables;

class TurmaController extends AdminController {
    /*
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index()
    {
        // Show the page
        return view('admin.turmas.index');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function getCreate() {
        return view('admin.turmas.create_edit');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function postCreate(TurmaRequest $request) {

        $turma = new Turma();
        $turma->nome = $request->nome;

        if($turma->save()) {
            return redirect("/admin/turmas");
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param $turma
     * @return Response
     */
    public function getEdit($id) {
        $turma = Turma::find($id);
        return view('admin.turmas.create_edit', compact('turma'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param $turma
     * @return Response
     */
    public function postEdit(TurmaEditRequest $request, $id) {
        $turma = Turma::find($id);
        $turma->nome = $request->nome;

        if($turma->save()) {
            return redirect("/admin/turmas/$id/edit");
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param $turma
     * @return Response
     */
    public function getDelete($id)
    {
        $turma = Turma::find($id);
        // Show the page
        return view('admin.turmas.delete', compact('user'));
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param $turma
     * @return Response
     */
    public function postDelete(DeleteRequest $request,$id)
    {
        $turma= Turma::find($id);
        $turma->delete();
    }
    /**
     * Show a list of all the languages posts formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function data()
    {
        $materias = Turma::select(array('turmas.id','turmas.nome'));
        return Datatables::of($materias)
            ->add_column('actions', '<a href="{{{ URL::to(\'admin/turmas/\' . $id . \'/edit\' ) }}}" class="btn btn-success btn-sm iframe" ><span class="glyphicon glyphicon-pencil"></span>  Editar</a>
                    <a href="{{{ URL::to(\'admin/turmas/\' . $id . \'/delete\' ) }}}" class="btn btn-sm btn-danger iframe"><span class="glyphicon glyphicon-trash"></span> Delete</a>
               ')
            ->remove_column('id')
            ->make();
    }
}