<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institution extends Model
{
    /** @use HasFactory<\Database\Factories\InstitutionFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'contact_email',
        'contact_phone',
        'status',
    ];

    public function placements()
    {
        return $this->hasMany(Placement::class);
    }
    public function users()
    {
        return $this->hasMany(User::class);
    }
}
