<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Placement extends Model
{
    /** @use HasFactory<\Database\Factories\PlacementFactory> */
    use HasFactory;

    protected $fillable = [
        'student_id',
        'institution_id',
        'mentor_id',
        'status',
        'start_date',
        'end_date',
    ];

    public function institution()
    {
        return $this->belongsTo(Institution::class, 'institution_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'student_id');
    }
    public function mentor()
    {
        return $this->belongsTo(User::class, 'mentor_id');
    }
}
