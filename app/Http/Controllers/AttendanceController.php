<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Placement;

class AttendanceController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->role === 'murid') {
            $attendances = Attendance::with(['placement.user', 'placement.institution'])
                ->whereHas('placement', fn($q) => $q->where('student_id', $user->id))->get();
        } elseif ($user->role === 'guru') {
            $attendances = Attendance::with(['placement.user', 'placement.institution'])
                ->whereHas('placement', fn($q) => $q->where('mentor_id', $user->id))->get();
        } else {
            $attendances = Attendance::with(['placement.user', 'placement.institution'])->get();
        }

        return view('attendances.index', ['attendances' => $attendances]);
    }

    public function show(Attendance $attendance)
    {
        $attendance->load(['placement.user', 'placement.institution']);
        return view('attendances.view', ['attendance' => $attendance]);
    }

    // === Murid only (protected by route middleware) ===

    public function create()
    {
        $user = auth()->user();
        $title = "Add new attendance record";
        $placements = Placement::with(['user', 'institution'])
            ->where('student_id', $user->id)->get();
        return view('attendances.create', ['title' => $title, 'placements' => $placements]);
    }

    public function store()
    {
        $data = request()->validate([
            'placement_id' => 'required|exists:placements,id',
            'date' => 'required|date',
            'status' => 'required|in:hadir,absen,sakit,izin',
            'clock_in' => 'nullable',
            'clock_out' => 'nullable',
            'notes' => 'nullable',
        ]);

        // Pastikan placement milik murid ini
        $user = auth()->user();
        $placement = Placement::where('id', $data['placement_id'])
            ->where('student_id', $user->id)->firstOrFail();

        Attendance::create($data);
        return redirect()->route('attendances.index')->with('success', 'Attendance record created successfully.');
    }

    public function edit(Attendance $attendance)
    {
        $user = auth()->user();
        $title = "Edit attendance record";
        $placements = Placement::with(['user', 'institution'])
            ->where('student_id', $user->id)->get();
        return view('attendances.edit', ['attendance' => $attendance, 'title' => $title, 'placements' => $placements]);
    }

    public function update(Attendance $attendance)
    {
        $data = request()->validate([
            'placement_id' => 'required|exists:placements,id',
            'date' => 'required|date',
            'status' => 'required|in:hadir,absen,sakit,izin',
            'clock_in' => 'nullable',
            'clock_out' => 'nullable',
            'notes' => 'nullable',
        ]);

        $attendance->update($data);
        return redirect()->route('attendances.index')->with('success', 'Attendance record updated successfully.');
    }

    public function delete(Attendance $attendance)
    {
        $attendance->delete();
        return redirect()->route('attendances.index')->with('success', 'Attendance record deleted successfully.');
    }
}