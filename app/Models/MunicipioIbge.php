<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MunicipioIbge extends Model
{
    /** @use HasFactory<\Database\Factories\MunicipioIbgeFactory> */
    use HasFactory;

    protected $table = 'municipio_ibgeS'; 
    protected $fillable =['ibge_id', 'ibge_name'];
}
