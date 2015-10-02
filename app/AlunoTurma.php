<?php
namespace App;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
class AlunoTurma extends Model implements AuthenticatableContract
{

    use Authenticatable;
    public $timestamps = false;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'aluno_turma';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['aluno_id', 'turma_id'];

    public function aluno() {
        return $this->belongsToMany('App\User', 'aluno_turma', 'aluno_id', 'id');
    }

    public function turmas() {
        return $this->hasMany('App\Turma');
    }
}