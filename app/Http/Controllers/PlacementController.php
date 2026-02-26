<?php

namespace App\Http\Controllers;

use App\Models\Placement;
use App\Models\User;
use App\Models\Institution;
use Illuminate\Http\Request;

class PlacementController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Global scope sudah membatasi berdasarkan institution_id secara otomatis.
        // Di sini hanya perlu filter berdasarkan ROLE (murid / guru).
        if ($user->role === 'murid') {
            $placements = Placement::with(['user', 'institution', 'mentor'])
                ->where('student_id', $user->id)->paginate(10);
        } elseif ($user->role === 'guru') {
            $placements = Placement::with(['user', 'institution', 'mentor'])
                ->where('mentor_id', $user->id)->paginate(10);
        } else {
            // Admin & Superadmin: global scope otomatis filter institution_id
            $placements = Placement::with(['user', 'institution', 'mentor'])->paginate(10);
        }

        return view('placements.index', ['placements' => $placements]);
    }

    public function show(Placement $placement)
    {
        // Global scope + route model binding sudah memastikan 404 jika bukan tenant-nya
        $placement->load(['user', 'institution', 'mentor']);
        $placement->loadCount(['evaluations', 'logbooks']);

        // Count attendances manually
        $placement->attendances_count = \App\Models\Attendance::where('placement_id', $placement->id)->count();

        return view('placements.show', compact('placement'));
    }

    public function attendances(Placement $placement)
    {
        $placement->load(['user', 'institution', 'mentor']);

        $attendances = \App\Models\Attendance::where('placement_id', $placement->id)
            ->orderBy('date', 'desc')->get();

        $todayAttendance = \App\Models\Attendance::where('placement_id', $placement->id)
            ->where('date', now()->toDateString())->first();

        // Calculate Recap
        $recap = [
            'total' => $attendances->count(),
            'hadir' => $attendances->where('status', 'hadir')->count(),
            'izin' => $attendances->where('status', 'izin')->count(),
            'sakit' => $attendances->where('status', 'sakit')->count(),
            'absen' => $attendances->where('status', 'absen')->count(),
        ];

        return view('placements.attendances', compact('placement', 'attendances', 'todayAttendance', 'recap'));
    }

    public function placementLogbooks(Placement $placement)
    {
        $placement->load(['user', 'institution']);

        $logbooks = $placement->logbooks()->orderBy('date', 'desc')->get();

        return view('placements.placement_logbooks', compact('placement', 'logbooks'));
    }

    public function placementEvaluations(Placement $placement)
    {
        $placement->load(['user', 'institution', 'mentor']);

        $evaluations = $placement->evaluations()->orderBy('created_at', 'desc')->get();

        return view('placements.placement_evaluations', compact('placement', 'evaluations'));
    }

    public function create()
    {
        $admin = auth()->user();

        if ($admin->role === 'superadmin') {
            $institutions = Institution::all();
            $students = User::where('role', 'murid')->get();
            $mentors = User::where('role', 'guru')->get();
        } else {
            $institutions = collect();
            $students = User::where('role', 'murid')
                ->where('institution_id', $admin->institution_id)->get();
            $mentors = User::where('role', 'guru')
                ->where('institution_id', $admin->institution_id)->get();
        }

        return view('placements.create', compact('institutions', 'students', 'mentors'));
    }

    public function store(Request $request)
    {
        $admin = auth()->user();

        $data = $request->validate([
            'student_id' => 'required|exists:users,id',
            'mentor_id' => 'required|exists:users,id',
            'institution_id' => $admin->role === 'superadmin' ? 'required|exists:institutions,id' : 'nullable',
            'status' => 'required|in:pending,accepted,rejected',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        // Paksa institution_id = institution admin (kecuali superadmin)
        if ($admin->role !== 'superadmin') {
            $data['institution_id'] = $admin->institution_id;
        }

        Placement::create($data);

        return redirect()->route('placements.index')->with('success', 'Placement berhasil dibuat.');
    }

    public function edit(Placement $placement)
    {
        $admin = auth()->user();

        if ($admin->role === 'superadmin') {
            $institutions = Institution::all();
            $students = User::where('role', 'murid')->get();
            $mentors = User::where('role', 'guru')->get();
        } else {
            $institutions = collect();
            $students = User::where('role', 'murid')
                ->where('institution_id', $admin->institution_id)->get();
            $mentors = User::where('role', 'guru')
                ->where('institution_id', $admin->institution_id)->get();
        }

        return view('placements.edit', compact('placement', 'institutions', 'students', 'mentors'));
    }

    public function update(Request $request, Placement $placement)
    {
        $admin = auth()->user();

        $data = $request->validate([
            'student_id' => 'required|exists:users,id',
            'mentor_id' => 'required|exists:users,id',
            'institution_id' => $admin->role === 'superadmin' ? 'required|exists:institutions,id' : 'nullable',
            'status' => 'required|in:pending,accepted,rejected',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        if ($admin->role !== 'superadmin') {
            $data['institution_id'] = $admin->institution_id;
        }

        $placement->update($data);

        return redirect()->route('placements.index')->with('success', 'Placement berhasil diperbarui.');
    }

    public function delete(Placement $placement)
    {
        $placement->delete();

        return redirect()->route('placements.index')->with('success', 'Placement berhasil dihapus.');
    }
}
