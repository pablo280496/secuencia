<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class elementoPizarra extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'tipo',
        'coordenadas',
        'cid',
        'pizarra_id',
    ];

    public function pizarra()
    {
        return $this->belongsTo(Pizarra::class, 'pizarra_id');
    }
    public function elementos() {
        return $this->hasMany(ElementoPizarra::class);
    }
}
