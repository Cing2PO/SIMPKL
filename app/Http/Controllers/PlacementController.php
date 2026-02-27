<?php

namespace App\Http\Controllers;

use App\Models\Placement;
use App\Models\User;
use App\Models\Institution;
use Illuminate\Http\Request;

class PlacementController extends Controller
{
    public function index(\Illuminate\Http\Request $request)
    {
        $user = auth()->user();
        $search = $request->input('search');
        $status = $request->input('status');

        $query = Placement::with(['user', 'institution', 'mentor']);

        if ($user->role === 'murid') {
            $query->where('student_id', $user->id);
        } elseif ($user->role === 'guru') {
            $query->where('mentor_id', $user->id);
        }

        // Search by student name or institution name
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', fn($u) => $u->where('name', 'like', "%{$search}%"))
                    ->orWhereHas('institution', fn($i) => $i->where('name', 'like', "%{$search}%"));
            });
        }

        // Filter by status
        if ($status) {
            $query->where('status', $status);
        }

        $placements = $query->paginate(10)->appends($request->query());

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
