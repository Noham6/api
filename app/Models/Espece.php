<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Espece extends Model
{
    protected $fillable = [
        'libelle',
        'temperature_min',
        'temperature_max',
        'humidite_min',
        'humidite_max',
        'description',
    ];

    public function animaux()
    {
        return $this->hasMany(Animaux::class, 'espece_id');
    }

    public function boxes()
    {
        return $this->hasMany(Box::class, 'espece_id');
    }
}
