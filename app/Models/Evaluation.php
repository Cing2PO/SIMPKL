<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    /** @use HasFactory<\Database\Factories\EvaluationFactory> */
    use HasFactory;

    protected $fillable = [
        'placement_id',
        'final_score',
        'feedback',
    ];

    public function placement()
    {
        return $this->belongsTo(Placement::class, 'placement_id');
    }
}
