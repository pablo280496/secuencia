<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class invitacion extends Model
{
    use HasFactory;

    protected $fillable = [
        'codigo',
        'pizarra_id',
        'expira_en',
        'creador_id',
    ];

    public function pizarra()
    {
        return $this->belongsTo(Pizarra::class, 'pizarra_id');
    }

    public function creador()
    {
        return $this->belongsTo(user::class, 'creador_id');
    }}
