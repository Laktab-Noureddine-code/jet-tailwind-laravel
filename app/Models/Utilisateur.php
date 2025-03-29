<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Utilisateur extends Model
{
    /** @use HasFactory<\Database\Factories\UtilisateurFactory> */
    use HasFactory;
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
}
