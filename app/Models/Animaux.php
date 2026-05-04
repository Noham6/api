<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Animaux extends Model
{
    use HasFactory;

    protected $table = 'animaux';

    protected $fillable = [
        'user_id',
        'espece_id',
        'nom',
        'race',
        'age',
        'poids',
        'description',
        'carnet_vaccination',
        'vaccin_a_jour',
        'vermifuge_a_jour',
    ];

    protected $casts = [
        'carnet_vaccination' => 'boolean',
        'vaccin_a_jour'      => 'boolean',
        'vermifuge_a_jour'   => 'boolean',
        'poids'              => 'float',
    ];

    public function espece()
    {
        return $this->belongsTo(Espece::class, 'espece_id');
    }

    public function proprietaire()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
