<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BigAffectation extends Model
{
    /** @use HasFactory<\Database\Factories\BigAffectationFactory> */
    use HasFactory;

    protected $fillable = [
        'fiche_affectations',
        'utilisateur_id'
    ];

    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class);
    }

    public function bigAffectationRows()
    {
        return $this->hasMany(BigAffectationRows::class);
    }

    public function materiels()
    {
        return $this->belongsToMany(Materiel::class, 'big_affectation_rows');
    }
}
