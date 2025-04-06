<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Telephone extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'pin',
        'puk',
        'materiel_id',
    ];

    public function materiel()
    {
        return $this->belongsTo(Materiel::class, 'materiel_id');
    }
}
