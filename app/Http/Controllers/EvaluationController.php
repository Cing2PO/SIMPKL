<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;

class EvaluationController extends Controller
{
    public function index()
    {
        $evaluations = Evaluation::all();
        return view('evaluations.index', ['evaluations' => $evaluations]);
    }
}
