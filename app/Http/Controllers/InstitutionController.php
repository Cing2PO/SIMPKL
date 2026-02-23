<?php

namespace App\Http\Controllers;

use App\Models\Institution;

class InstitutionController extends Controller
{
    public function index()
    {
        $institutions = Institution::all();
        return view('institutions.index', ['institutions' => $institutions]);
    }
}
