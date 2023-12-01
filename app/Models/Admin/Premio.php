<?php
namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Premio extends Model
{
    protected $table = 'premio'; 

    protected $primaryKey = 'idPremio'; 

    protected $fillable = [
        'nombre',
        "idUsuario",
        'flag',
    ];

    public $incrementing = true; 
    public $timestamps = false;
}