<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Box extends Model
{
    protected $fillable = ['pension_id', 'espece_id', 'superficie'];

    public function pension()
    {
        return $this->belongsTo(Pension::class);
    }

    public function espece()
    {
        return $this->belongsTo(Espece::class, 'espece_id');
    }
}

