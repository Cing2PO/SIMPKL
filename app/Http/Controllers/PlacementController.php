<?php

namespace App\Http\Controllers;

use App\Models\Placement;

class PlacementController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'murid') {
            $placements = Placement::with(['user', 'institution', 'mentor'])
                ->where('student_id', $user->id)->get();
        } elseif ($user->role === 'guru') {
            $placements = Placement::with(['user', 'institution', 'mentor'])
                ->where('mentor_id', $user->id)->get();
        } else {
            $placements = Placement::with(['user', 'institution', 'mentor'])->get();
        }

        return view('placements.index', ['placements' => $placements]);
    }
}
