<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produto extends Model
{
    /** @use HasFactory<\Database\Factories\ProdutoFactory> */
    use HasFactory, SoftDeletes;

    protected $table = 'produtos';

    protected $fillable = ['name', 'category', 'status', 'quantity'];

    protected $casts = [
        'status' => 'string',
    ];
}
