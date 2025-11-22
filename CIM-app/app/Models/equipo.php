<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class equipo extends Model
{
    protected $table = 'equipo';

    protected $fillable = [
        'IdEqo',
        'IdLab',
        'NombreEqo',
        'CodigoEqo',
        'EstadoEqo'
    ];

    protected $primaryKey = 'IdEqo';
    public $timestamps = true;

    // Relaciones
    public function laboratorio()
    {
        return $this->belongsTo(laboratorio::class, 'IdLab', 'IdLab');
    }
    public function perifericos()
    {
        return $this->hasMany(periferico::class, 'IdEqo', 'IdEqo');
    }

    public function scopeSearch($query, $search = null, $idLab = null)
    {
        if (!empty($search)) {
            return $query->where(function ($q) use ($search) {
                $q->where('NombreEqo', 'LIKE', '%' . trim($search) . '%')
                    ->orWhere('CodigoEqo', 'LIKE', '%' . trim($search) . '%');
            });
        }
        if (!empty($idLab)) {
            $query->where('IdLab', $idLab);
        }
        return $query;
    }
}
