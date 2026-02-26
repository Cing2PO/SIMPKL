<?php

namespace App\Models;

use App\Models\Scopes\TenantScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    /** @use HasFactory<\Database\Factories\AttendanceFactory> */
    use HasFactory;

    protected static function booted(): void
    {
        static::addGlobalScope(new TenantScope());
    }

    protected $fillable = [
        'placement_id',
        'date',
        'status',
        'clock_in',
        'clock_out',
        'notes',
    ];

    public function placement()
    {
        return $this->belongsTo(Placement::class, 'placement_id');
    }
}
