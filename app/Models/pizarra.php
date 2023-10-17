<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class pizarra extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'descripcion',
        'creador_id',
        'invitation_code',
    ];

    public function creador()
    {
        return $this->belongsTo(user::class, 'creador_id');
    }

    public function participantes()
    {
        return $this->belongsToMany(user::class, 'usuario_pizarra', 'pizarra_id', 'usuario_id')
            ->withPivot('rol');
    }

    public function elementos()
    {
        return $this->hasMany(ElementoPizarra::class, 'pizarra_id');
    }

    public function invitaciones()
    {
        return $this->hasMany(Invitacion::class, 'pizarra_id');
    }
}
