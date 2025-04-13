<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Recrutement extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'nom',
        'fonction',
        'departement',
        'email',
        'type_contrat',
        'telephone',
        'model',
        'date_affectation',
        'num_serie',
        'puk',
        'pin',
        'status',
    ];

    public function notification()
    {
        return $this->hasOne(Notification::class);
    }
}
