<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class plans extends Model
{
    protected $fillable = [
        'name',
        'price',
        'duration',
        'features',
    ];

    public function institutions()
    {
        return $this->hasMany(institution::class);
    }
}
