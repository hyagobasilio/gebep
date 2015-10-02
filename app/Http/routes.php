<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('/', function () {
    return view('test');
});

Route::controllers([
    'auth' => 'Auth\AuthController',
    'password' => 'Auth\PasswordController',
]);

/*Route::get('admin', function() {
	return view('admin_template');
});*/
Route::get('home', 'PostController@teste');
Route::get('faltas', 'Admin\FaltaController@getFaltasTurma');
Route::group(['prefix' => 'admin', 'middleware' => 'auth', 'namespace' => 'Admin'], function() {
    Route::pattern('id', '[0-9]+');
    Route::pattern('id2', '[0-9]+');
    # Admin Dashboard
    Route::get('dashboard', 'DashboardController@index');

    # Users
    Route::get('users', 'UserController@index');
    Route::get('users/create', 'UserController@getCreate');
    Route::post('users/create', 'UserController@postCreate');
    Route::get('users/{id}/edit', 'UserController@getEdit');
    Route::get('users/{id}/delete', 'UserController@getDelete');
    Route::post('users/{id}/delete', 'UserController@postDelete');
    Route::get('users/data', 'UserController@data');

    Route::get('users/professores', 'UserController@getProfessores');

    #Materias
    Route::get('materias', 'MateriaController@index');
    Route::get('materias/data', 'MateriaController@data');
    Route::get('materias/create', 'MateriaController@getCreate');
    Route::post('materias/create', 'MateriaController@postCreate');
    Route::post('materias/{id}/edit', 'MateriaController@postEdit');
    Route::get('materias/{id}/edit', 'MateriaController@getEdit');

    Route::get('materias/{idProfessor}/{idTurma}/materias', 'MateriaController@getMateriasProfessorTurma');

    Route::get('materias/{idProfessor}/materias', 'MateriaController@getEdit');

    #Turmas
    Route::get('turmas', 'TurmaController@index');
    Route::get('turmas/data', 'TurmaController@data');
    Route::get('turmas/create', 'TurmaController@getCreate');
    Route::post('turmas/create', 'TurmaController@postCreate');
    Route::post('turmas/{id}/edit', 'TurmaController@postEdit');
    Route::get('turmas/{id}/edit', 'TurmaController@getEdit');

    #Realacionamento Alunos turma
    Route::get('alunos-turma', 'AlunoTurmaController@index');
    Route::post('alunos-turma/create', 'AlunoTurmaController@postCreate');
    Route::get('alunos-turma/{idTurma}/alunos', 'AlunoTurmaController@getAlunosRelacionados');

    #Realacionamento Professor Materias
    Route::get('professor-materias', 'ProfessorMateriaController@index');
    Route::post('professor-materias/create', 'ProfessorMateriaController@postCreate');
    Route::get('professor-materias/{idProfessor}/materias', 'ProfessorMateriaController@getMateriasRelacionadas');

    #Realacionamento Professor Turma
    Route::get('professor-turmas', 'ProfessorTurmaController@index');
    Route::post('professor-turmas/create', 'ProfessorTurmaController@postCreate');
    Route::get('professor-turmas/{idProfessor}/turmas', 'ProfessorTurmaController@getTurmasRelacionadas');

    #Realacionamento Materias turma
    Route::get('materias-turma', 'MateriaTurmaController@index');
    Route::post('materias-turma/create', 'MateriaTurmaController@postCreate');
    Route::get('materias-turma/{idTurma}/materias', 'MateriaTurmaController@getMateriasRelacionadas');

    #Faltas
    Route::get('faltas', 'FaltaController@index');
    Route::post('faltas/create', 'FaltaController@store');
    Route::get('faltas/turma/{idTurma}/meteria/{idMateria}', [ 'as' => 'faltas.turma', 'uses' => 'FaltaController@getFaltasTurma']);




});


