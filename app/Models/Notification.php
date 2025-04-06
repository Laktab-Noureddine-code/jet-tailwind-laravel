<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Notification extends Model
{
    use HasFactory, SoftDeletes;
    protected $fillable = [
        'recrutement_id',
        'is_read',
        'type', //materiel
        'etat', //materiel
        'date_affectation', //affectation
        'chantier', //affectation   
        'utilisateur', //affectation   
    ];
    public function recrutement()
    {
        return $this->belongsTo(Recrutement::class);
    }
}
