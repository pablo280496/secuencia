<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class usuario_pizarra extends Model
{
    protected $table = 'usuario_pizarra';

    protected $fillable = [
        'id_user',
        'id_pizarra',
        'rol',
    ];

    public function usuario()
    {
        return $this->belongsTo(user::class, 'usuario_id');
    }

    public function pizarra()
    {
        return $this->belongsTo(Pizarra::class, 'pizarra_id');
    }
}
