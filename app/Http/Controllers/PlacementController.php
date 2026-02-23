<?php

namespace App\Http\Controllers;

use App\Models\Placement;

class PlacementController extends Controller
{
    public function index()
    {
        $placements = Placement::all();
        return view('placements.index', ['placements' => $placements]);
    }
}
