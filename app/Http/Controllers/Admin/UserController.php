<?php 
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\AdminController;
use App\User;
use App\Http\Requests\Admin\UserRequest;
use App\Http\Requests\Admin\UserEditRequest;
use App\Http\Requests\Admin\DeleteRequest;
use App\Helpers\Thumbnail;
use Datatables;
use Illuminate\Support\Facades\Auth;

class UserController extends AdminController {
    /*
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index()
    {
        // Show the page
        return view('admin.users.index');
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function getCreate() {
        return view('admin.users.create_edit');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function postCreate(UserRequest $request) {

        $user = new User ();
        $user->name = $request->name;
        $user->tipo_usuario = $request->tipo_usuario;
		$user->username = $request->username;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->confirmation_code = str_random(32);
        $user->confirmed = $request->confirmed;
        $picture = "";
        if($request->hasFile('image')) {
            $file = $request->file('image');
            $filename = $file->getClientOriginalName();
            $extension = $file -> getClientOriginalExtension();
            $picture = sha1($filename . time()) . '.' . $extension;

            $destinationPath = public_path() . '/uploads/users/fotos/';
            $request->file('image')->move($destinationPath, $picture);

            $path2 = public_path() . '/uploads/users/fotos/thumbs/';
            Thumbnail::generate_image_thumbnail($destinationPath . $picture, $path2 . $picture);
        }
        $user -> filename = $picture;
                
        if($user->save()) {
            return redirect("/admin/users");
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param $user
     * @return Response
     */
    public function getEdit($id) {
        $user = User::find($id);
        return view('admin.users.create_edit', compact('user'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param $user
     * @return Response
     */
    public function postEdit(UserEditRequest $request, $id) {
        $user = User::find($id);
        $user->name = $request->name;
        $user->tipo_usuario = $request->tipo_usuario;
        $user->confirmed = $request->confirmed;
        $password = $request->password;
        $passwordConfirmation = $request->password_confirmation;
        if (!empty($password)) {
            if ($password === $passwordConfirmation) {
                $user->password = bcrypt($password);
            }
        }
        $picture = $user->filename;
        if($request->hasFile('image'))
        {
            $file = $request->file('image');
            $filename = $file->getClientOriginalName();
            $extension = $file -> getClientOriginalExtension();
            $picture = sha1($filename . time()) . '.' . $extension;

            $destinationPath = public_path() . '/uploads/users/fotos/';
            $request->file('image')->move($destinationPath, $picture);

            $path2 = public_path() . '/uploads/users/fotos/thumbs/';
            Thumbnail::generate_image_thumbnail($destinationPath . $picture, $path2 . $picture);
        }
        $user->filename = $picture;


        if($user->save()) {
            return redirect("/admin/users/$id/edit");
        }
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param $user
     * @return Response
     */
    public function getDelete($id)
    {
        $user = User::find($id);
        // Show the page
        return view('admin.users.delete', compact('user'));
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param $user
     * @return Response
     */
    public function postDelete(DeleteRequest $request,$id)
    {
        $user= User::find($id);
        $user->delete();
    }
    /**
     * Show a list of all the languages posts formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function data()
    {
        $users = User::select(array('users.id','users.name','users.email','users.confirmed', 'users.created_at'));
        return Datatables::of($users)
            ->edit_column('confirmed', '@if ($confirmed=="1") <span class="glyphicon glyphicon-ok"></span> @else <span class=\'glyphicon glyphicon-remove\'></span> @endif')
            ->add_column('actions', '@if ($id!="1")<a href="{{{ URL::to(\'admin/users/\' . $id . \'/edit\' ) }}}" class="btn btn-success btn-sm iframe" ><span class="glyphicon glyphicon-pencil"></span>  Editar</a>
                    <a href="{{{ URL::to(\'admin/users/\' . $id . \'/delete\' ) }}}" class="btn btn-sm btn-danger iframe"><span class="glyphicon glyphicon-trash"></span> Delete</a>
                @endif')
            ->remove_column('id')
            ->make();
    }

    public function getProfessores()
    {
        $professores = User::select('users.id', 'users.name as nome')
        ->where('tipo_usuario', 1)
        ->get();
        $dados['professores'] = $professores;

        return response()->json($dados);
    }
}