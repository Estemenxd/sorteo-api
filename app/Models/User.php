<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasFactory, Notifiable;

    protected $table="usuarios";

    protected $primaryKey = 'idUsuario';

    public $incrementing = true;
    protected $keyType = 'int';
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'codigo',
        'dni',
        'nombres',
        'aPaterno',
        'aMaterno',
        'usuario',
        'password',
        'direccion',
        'flag',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
    ];

    // Se agrega estas funciones para usarlos con JWT

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
    public function getJWTCustomClaims()
    {
        return [];
    }

    public static function login($user, $key)
    {
        $data = DB::select("SELECT  
                            idUsuario,
                            dni,
                            aPaterno, 
                            aMaterno,
                            nombres,
                            correo,
                            idRol,
                            flag,
                            usuario FROM  usuarios WHERE usuario = ? and password = ?", [$user, md5($key)]);
        return $data;
    }
}
