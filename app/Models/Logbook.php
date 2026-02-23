<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logbook extends Model
{
    /** @use HasFactory<\Database\Factories\LogbookFactory> */
    use HasFactory;

    protected $fillable = [
        'placement_id',
        'date',
        'activity',
        'description',
    ];

    public function placement()
    {
        return $this->belongsTo(Placement::class, 'placement_id');
    }
}
