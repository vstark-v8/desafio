<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Consultas_iten extends Model
{
    use HasFactory;

    protected $fillable = [
        'mecanico_id',
        'produto_id',
        'quantidade',
        'valor',
        'consulta_id',
        
    ];
}
