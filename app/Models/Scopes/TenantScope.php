<?php

namespace App\Models\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class TenantScope implements Scope
{
    /**
     * Apply the scope to a given Eloquent query builder.
     */
    public function apply(Builder $builder, Model $model): void
    {
        if (!auth()->check())
            return; // saat seeding / artisan
        $user = auth()->user();
        if ($user->role === 'superadmin')
            return; // no filter
        $institutionId = $user->institution_id;
        // Model dengan institution_id langsung
        if (in_array('institution_id', $model->getFillable())) {
            $builder->where($model->getTable() . '.institution_id', $institutionId);
        } else {
            // Model yang relasinya lewat placement (Logbook, Attendance, Evaluation)
            $builder->whereHas(
                'placement',
                fn($q) =>
                $q->where('institution_id', $institutionId)
            );
        }
    }
}
