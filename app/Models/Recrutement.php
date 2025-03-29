<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Recrutement extends Model
{
    protected $fillable = [
        'nom',
        'fonction',
        'departement',
        'email',
        'type_contrat',
        'telephone',
        'model',
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
