<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;

class Materiel extends Model
{
    /** @use HasFactory<\Database\Factories\MaterielFactory> */
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'fabricant',
        'type',
        'num_serie',
        'etat',
        'num_commande'
    ];
    public function affectations()
    {
        return $this->hasMany(Affectation::class);
    }
    public function imprimante(): HasOne
    {
        return $this->hasOne(Imprimante::class, 'materiel_id');
    }
    public function ordinateur(): HasOne
    {
        return $this->hasOne(Ordinateur::class, 'materiel_id');
    }
    public function telephone(): HasOne
    {
        return $this->hasOne(Telephone::class, 'materiel_id');
    }

    /**
     * Relation avec le modèle Toner (si ce matériel est une imprimante).
     */
}
