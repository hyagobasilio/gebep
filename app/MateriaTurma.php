<?php
namespace App;
use Illuminate\Auth\Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\SoftDeletes;
class MateriaTurma extends Model implements AuthenticatableContract
{

    use Authenticatable;
    public $timestamps = false;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'materia_turma';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['materia_id', 'turma_id'];

    public function materias() {
        return $this->belongsTo('App\Materia');
    }

    public function turmas() {
        return $this->hasMany('App\Turma');
    }
}