<?php
namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Evento extends Model
{
    protected $table = 'evento'; 

    protected $primaryKey = 'idEvento'; 

    protected $fillable = [
        'nombre',
        'idUsuario',
        'flag',
    ];

    public $incrementing = true; 
    public $timestamps = false;
}