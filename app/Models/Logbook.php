<?php

namespace App\Models;

use App\Models\Scopes\TenantScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Logbook extends Model
{
    /** @use HasFactory<\Database\Factories\LogbookFactory> */
    use HasFactory;

    protected static function booted(): void
    {
        static::addGlobalScope(new TenantScope());
    }

    protected $fillable = [
        'placement_id',
        'date',
        'activity',
        'description',
        'institution_id',
    ];

    public function placement()
    {
        return $this->belongsTo(Placement::class, 'placement_id');
    }

    public function institution()
    {
        return $this->belongsTo(Institution::class, 'institution_id');
    }
}
