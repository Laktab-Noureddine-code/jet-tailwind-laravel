<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BigAffectationRows extends Model
{
    /** @use HasFactory<\Database\Factories\BigAffectationRowsFactory> */
    use HasFactory;

    protected $fillable = [
        'big_affectation_id',
        'materiel_id'
    ];

    public function bigAffectation()
    {
        return $this->belongsTo(BigAffectation::class);
    }

    public function materiel()
    {
        return $this->belongsTo(Materiel::class);
    }
}
