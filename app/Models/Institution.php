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
        'plan_id',
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

    public function plans()
    {
        return $this->belongsTo(plans::class);
    }
}
