<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Affectation extends Model
{
    /** @use HasFactory<\Database\Factories\AffectationFactory> */
    use HasFactory;
    protected $fillable = [
        'materiel_id',
        'utilisateur_id',
        'date_affectation',
        'fiche_affectation',
        'statut',
        'chantier',
        'utilisateur1'
    ];
    

    public function materiel()
    {
        return $this->belongsTo(Materiel::class, 'materiel_id');
    }

    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class);
    }
}
