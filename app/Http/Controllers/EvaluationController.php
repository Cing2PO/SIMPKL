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
                ->whereHas('placement', fn($q) => $q->where('student_id', $user->id))->paginate(10);
        } elseif ($user->role === 'guru') {
            $evaluations = Evaluation::with(['placement.user', 'placement.institution'])
                ->whereHas('placement', fn($q) => $q->where('mentor_id', $user->id))->paginate(10);
        } else {
            // Admin: hanya evaluasi dari institusi sendiri
            $evaluations = Evaluation::with(['placement.user', 'placement.institution'])
                ->whereHas('placement', fn($q) => $q->where('institution_id', $user->institution_id))->paginate(10);
        }

        return view('evaluations.index', ['evaluations' => $evaluations]);
    }

    // === Guru only (protected by route middleware) ===

    public function show(Placement $placement, Evaluation $evaluation)
    {
        // Pastikan evaluation milik placement ini
        if ($evaluation->placement_id !== $placement->id) {
            abort(404);
        }

        $evaluation->load(['placement.user', 'placement.institution']);
        return view('evaluations.view', compact('placement', 'evaluation'));
    }

    public function create(Placement $placement)
    {
        $user = auth()->user();

        // Pastikan guru ini adalah mentor dari placement ini
        if ($placement->mentor_id !== $user->id) {
            abort(403, 'Anda bukan mentor dari placement ini.');
        }

        $placement->load(['user', 'institution']);
        $title = "Add new evaluation";
        return view('evaluations.create', compact('title', 'placement'));
    }

    public function store(Placement $placement)
    {
        $user = auth()->user();

        // Pastikan guru ini adalah mentor dari placement ini
        if ($placement->mentor_id !== $user->id) {
            abort(403, 'Anda bukan mentor dari placement ini.');
        }

        $data = request()->validate([
            'final_score' => 'nullable|integer|min:0|max:100',
            'feedback' => 'required|string',
        ]);

        $data['placement_id'] = $placement->id;

        Evaluation::create($data);
        return redirect()->route('placements.show', $placement)
            ->with('success', 'Evaluation berhasil dibuat.');
    }

    public function edit(Placement $placement, Evaluation $evaluation)
    {
        $user = auth()->user();

        // Pastikan evaluation milik placement ini
        if ($evaluation->placement_id !== $placement->id) {
            abort(404);
        }

        // Pastikan guru ini adalah mentor
        if ($placement->mentor_id !== $user->id) {
            abort(403, 'Anda bukan mentor dari placement ini.');
        }

        $placement->load(['user', 'institution']);
        $title = "Edit evaluation";
        return view('evaluations.edit', compact('evaluation', 'title', 'placement'));
    }

    public function update(Placement $placement, Evaluation $evaluation)
    {
        // Pastikan evaluation milik placement ini
        if ($evaluation->placement_id !== $placement->id) {
            abort(404);
        }

        $data = request()->validate([
            'final_score' => 'nullable|integer|min:0|max:100',
            'feedback' => 'required|string',
        ]);

        $evaluation->update($data);
        return redirect()->route('placements.show', $placement)
            ->with('success', 'Evaluation berhasil diperbarui.');
    }

    public function delete(Placement $placement, Evaluation $evaluation)
    {
        // Pastikan evaluation milik placement ini
        if ($evaluation->placement_id !== $placement->id) {
            abort(404);
        }

        $evaluation->delete();
        return redirect()->route('placements.show', $placement)
            ->with('success', 'Evaluation berhasil dihapus.');
    }
}
