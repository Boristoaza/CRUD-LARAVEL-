<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Idols extends Model
{
    protected $table = 'idols';
    protected $fillable = ['id','nombre', 'edad','datos_curiosos','actividad','foto' ];
}
