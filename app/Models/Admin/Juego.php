<?php
namespace App\Models\Admin;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;

class Juego extends Model
{
    protected $table = 'juego'; 
    protected $primaryKey = 'idJuego';
    public $incrementing = true; 
    public $timestamps = false; 

    protected $fillable = [
        'nombre',
        'descripcion',
        'flag',
    ];

   
}