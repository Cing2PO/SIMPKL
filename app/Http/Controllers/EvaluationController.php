<?php

namespace App\Http\Controllers;

use App\Models\Evaluation;
use App\Models\Placement;

class EvaluationController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'murid') {
            $evaluations = Evaluation::with(['placement.user', 'placement.institution'])
                ->whereHas('placement', fn($q) => $q->where('student_id', $user->id))->get();
        } elseif ($user->role === 'guru') {
            $evaluations = Evaluation::with(['placement.user', 'placement.institution'])
                ->whereHas('placement', fn($q) => $q->where('mentor_id', $user->id))->get();
        } else {
            // Admin: hanya evaluasi dari institusi sendiri
            $evaluations = Evaluation::with(['placement.user', 'placement.institution'])
                ->whereHas('placement', fn($q) => $q->where('institution_id', $user->institution_id))->get();
        }

        return view('evaluations.index', ['evaluations' => $evaluations]);
    }

    // === Guru only (protected by route middleware) ===

    public function show(Evaluation $evaluation)
    {
        $evaluation->load(['placement.user', 'placement.institution']);
        return view('evaluations.view', ['evaluation' => $evaluation]);
    }

    public function create()
    {
        $user = auth()->user();
        $title = "Add new evaluation";
        $placements = Placement::with(['user', 'institution'])
            ->where('mentor_id', $user->id)->get();
        return view('evaluations.create', compact('title', 'placements'));
    }

    public function store()
    {
        $data = request()->validate([
            'placement_id' => 'required|exists:placements,id',
            'final_score' => 'nullable|integer|min:0|max:100',
            'feedback' => 'required|string',
        ]);

        // Pastikan placement milik guru ini (sebagai mentor)
        $user = auth()->user();
        Placement::where('id', $data['placement_id'])
            ->where('mentor_id', $user->id)->firstOrFail();

        Evaluation::create($data);
        return redirect()->route('evaluations.index')->with('success', 'Evaluation created successfully.');
    }

    public function edit(Evaluation $evaluation)
    {
        $user = auth()->user();
        $title = "Edit evaluation";
        $placements = Placement::with(['user', 'institution'])
            ->where('mentor_id', $user->id)->get();
        return view('evaluations.edit', compact('evaluation', 'title', 'placements'));
    }

    public function update(Evaluation $evaluation)
    {
        $data = request()->validate([
            'placement_id' => 'required|exists:placements,id',
            'final_score' => 'nullable|integer|min:0|max:100',
            'feedback' => 'required|string',
        ]);

        $evaluation->update($data);
        return redirect()->route('evaluations.index')->with('success', 'Evaluation updated successfully.');
    }

    public function delete(Evaluation $evaluation)
    {
        $evaluation->delete();
        return redirect()->route('evaluations.index')->with('success', 'Evaluation deleted successfully.');
    }
}
