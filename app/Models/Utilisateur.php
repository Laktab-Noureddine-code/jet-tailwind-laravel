<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Utilisateur extends Model
{
    /** @use HasFactory<\Database\Factories\UtilisateurFactory> */
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'nom',
        'fonction',
        'telephone',
        'email',
        'departement'
    ];
    public function affectations()
    {
        return $this->hasMany(Affectation::class);
    }

    public function bigAffectations()
    {
        return $this->hasMany(BigAffectation::class);
    }
}
