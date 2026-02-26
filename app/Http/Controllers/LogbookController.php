<?php

namespace App\Http\Controllers;

use App\Models\Logbook;
use App\Models\Placement;

class LogbookController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Global scope otomatis memfilter logbook berdasarkan institution_id via placement.
        if ($user->role === 'murid') {
            $logbooks = Logbook::with(['placement.user', 'placement.institution'])
                ->whereHas('placement', fn($q) => $q->where('student_id', $user->id))->paginate(10);
        } elseif ($user->role === 'guru') {
            $logbooks = Logbook::with(['placement.user', 'placement.institution'])
                ->whereHas('placement', fn($q) => $q->where('mentor_id', $user->id))->paginate(10);
        } else {
            // Admin & Superadmin: global scope otomatis enforce institution filter
            $logbooks = Logbook::with(['placement.user', 'placement.institution'])->paginate(10);
        }

        return view('logbooks.index', ['logbooks' => $logbooks]);
    }

    public function show(Placement $placement, Logbook $logbook)
    {
        // Pastikan logbook milik placement ini
        if ($logbook->placement_id !== $placement->id) {
            abort(404);
        }

        $logbook->load(['placement.user', 'placement.institution']);
        return view('logbooks.view', compact('placement', 'logbook'));
    }

    // === Murid only (protected by route middleware) ===

    public function create(Placement $placement)
    {
        $user = auth()->user();

        // Pastikan placement milik murid ini
        if ($placement->student_id !== $user->id) {
            abort(403, 'Ini bukan placement Anda.');
        }

        $placement->load(['user', 'institution']);
        $title = "Add new logbook entry";
        return view('logbooks.create', compact('title', 'placement'));
    }

    public function store(Placement $placement)
    {
        $user = auth()->user();

        // Pastikan placement milik murid ini
        if ($placement->student_id !== $user->id) {
            abort(403, 'Ini bukan placement Anda.');
        }

        $data = request()->validate([
            'date' => 'required|date',
            'activity' => 'required',
            'description' => 'required',
        ]);

        $data['placement_id'] = $placement->id;

        Logbook::create($data);
        return redirect()->route('placements.show', $placement)
            ->with('success', 'Logbook entry berhasil dibuat.');
    }

    public function edit(Placement $placement, Logbook $logbook)
    {
        $user = auth()->user();

        // Pastikan logbook milik placement ini
        if ($logbook->placement_id !== $placement->id) {
            abort(404);
        }

        // Pastikan placement milik murid ini
        if ($placement->student_id !== $user->id) {
            abort(403, 'Ini bukan placement Anda.');
        }

        $placement->load(['user', 'institution']);
        $title = "Edit logbook entry";
        return view('logbooks.edit', compact('logbook', 'title', 'placement'));
    }

    public function update(Placement $placement, Logbook $logbook)
    {
        // Pastikan logbook milik placement ini
        if ($logbook->placement_id !== $placement->id) {
            abort(404);
        }

        $data = request()->validate([
            'date' => 'required|date',
            'activity' => 'required',
            'description' => 'required',
        ]);

        $logbook->update($data);
        return redirect()->route('placements.show', $placement)
            ->with('success', 'Logbook entry berhasil diperbarui.');
    }

    public function delete(Placement $placement, Logbook $logbook)
    {
        // Pastikan logbook milik placement ini
        if ($logbook->placement_id !== $placement->id) {
            abort(404);
        }

        $logbook->delete();
        return redirect()->route('placements.show', $placement)
            ->with('success', 'Logbook entry berhasil dihapus.');
    }
}
