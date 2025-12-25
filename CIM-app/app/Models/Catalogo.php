<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Catalogo extends Model
{
    use HasFactory;

    protected $table = 'catalogo';
    protected $primaryKey = 'IdCat';
    public $timestamps = true;

    // IMPORTANTE: si tu IdCat es BIGINT (lo típico con $table->id()),
    // no es necesario cambiar $keyType. Si fuese string, sí.
    // public $incrementing = true;
    // protected $keyType = 'int';

    protected $fillable = [
        'NombreCat',
        'IdPadre',
        'EstadoCat',
    ];

    /**
     * Padre (ej: COLOR, MARCA, etc.)
     */
    public function padre()
    {
        return $this->belongsTo(self::class, 'IdPadre', 'IdCat');
    }

    /**
     * Hijos (ej: NEGRO, GRIS, HP, DELL, etc.)
     */
    public function hijos()
    {
        return $this->hasMany(self::class, 'IdPadre', 'IdCat');
    }

    /**
     * Scope: solo activos
     */
    public function scopeActivos($query)
    {
        return $query->where('EstadoCat', 1);
    }
}
