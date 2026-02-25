<?php

namespace App\Http\Controllers;

use App\Models\Logbook;
use App\Models\Placement;

class LogbookController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'murid') {
            $logbooks = Logbook::with(['placement.user', 'placement.institution'])
                ->whereHas('placement', fn($q) => $q->where('student_id', $user->id))->get();
        } elseif ($user->role === 'guru') {
            $logbooks = Logbook::with(['placement.user', 'placement.institution'])
                ->whereHas('placement', fn($q) => $q->where('mentor_id', $user->id))->get();
        } else {
            // Admin: hanya logbook dari institusi sendiri
            $logbooks = Logbook::with(['placement.user', 'placement.institution'])
                ->whereHas('placement', fn($q) => $q->where('institution_id', $user->institution_id))->get();
        }

        return view('logbooks.index', ['logbooks' => $logbooks]);
    }

    public function show(Logbook $logbook)
    {
        $logbook->load(['placement.user', 'placement.institution']);
        return view('logbooks.view', ['logbook' => $logbook]);
    }

    // === Murid only (protected by route middleware) ===

    public function create()
    {
        $user = auth()->user();
        $title = "Add new logbook entry";
        $placements = Placement::with(['user', 'institution'])
            ->where('student_id', $user->id)->get();
        return view('logbooks.create', ['title' => $title, 'placements' => $placements]);
    }

    public function store()
    {
        $data = request()->validate([
            'placement_id' => 'required|exists:placements,id',
            'date' => 'required|date',
            'activity' => 'required',
            'description' => 'required',
        ]);

        // Pastikan placement milik murid ini
        $user = auth()->user();
        Placement::where('id', $data['placement_id'])
            ->where('student_id', $user->id)->firstOrFail();

        Logbook::create($data);
        return redirect()->route('logbooks.index')->with('success', 'Logbook entry created successfully.');
    }

    public function edit(Logbook $logbook)
    {
        $user = auth()->user();
        $title = "Edit logbook entry";
        $placements = Placement::with(['user', 'institution'])
            ->where('student_id', $user->id)->get();
        return view('logbooks.edit', ['logbook' => $logbook, 'title' => $title, 'placements' => $placements]);
    }

    public function update(Logbook $logbook)
    {
        $data = request()->validate([
            'placement_id' => 'required|exists:placements,id',
            'date' => 'required|date',
            'activity' => 'required',
            'description' => 'required',
        ]);

        $logbook->update($data);
        return redirect()->route('logbooks.index')->with('success', 'Logbook entry updated successfully.');
    }

    public function delete(Logbook $logbook)
    {
        $logbook->delete();
        return redirect()->route('logbooks.index')->with('success', 'Logbook entry deleted successfully.');
    }
}
