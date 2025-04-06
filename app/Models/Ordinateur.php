<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ordinateur extends Model
{
    /** @use HasFactory<\Database\Factories\OrdinateurFactory> */
    use HasFactory, SoftDeletes;
    protected $fillable = ['materiel_id', 'ram', 'stockage', 'processeur'];

    public function materiel()
    {
        return $this->belongsTo(Materiel::class, 'materiel_id');
    }
}
