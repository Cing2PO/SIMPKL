<?php

namespace App\Http\Controllers;

use App\Models\Logbook;
use App\Models\Placement;

class LogbookController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $user = auth()->user();
        $search = $request->input('search');
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');

        $query = Logbook::with(['placement.user', 'placement.institution']);

        if ($user->role === 'murid') {
            $query->whereHas('placement', fn($q) => $q->where('student_id', $user->id));
        } elseif ($user->role === 'guru') {
            $query->whereHas('placement', fn($q) => $q->where('mentor_id', $user->id));
        }

        // Search by activity text or student name
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('activity', 'like', "%{$search}%")
                    ->orWhereHas('placement.user', fn($u) => $u->where('name', 'like', "%{$search}%"));
            });
        }

        // Date range filter
        if ($dateFrom) {
            $query->whereDate('date', '>=', $dateFrom);
        }
        if ($dateTo) {
            $query->whereDate('date', '<=', $dateTo);
        }

        $logbooks = $query->orderBy('date', 'desc')->paginate(10)->appends($request->query());

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
        $data['institution_id'] = $placement->institution_id;

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
