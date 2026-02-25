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

        if ($user->role === 'murid') {
            $placements = Placement::with(['user', 'institution', 'mentor'])
                ->where('student_id', $user->id)->get();
        } elseif ($user->role === 'guru') {
            $placements = Placement::with(['user', 'institution', 'mentor'])
                ->where('mentor_id', $user->id)->get();
        } elseif ($user->role === 'superadmin') {
            $placements = Placement::with(['user', 'institution', 'mentor'])->get();
        } else {
            // Admin: hanya placement dari institusi sendiri
            $placements = Placement::with(['user', 'institution', 'mentor'])
                ->where('institution_id', $user->institution_id)->get();
        }

        return view('placements.index', ['placements' => $placements]);
    }

    public function create()
    {
        $admin = auth()->user();

        if ($admin->role === 'superadmin') {
            $institutions = Institution::all();
            $students = User::where('role', 'murid')->get();
            $mentors = User::where('role', 'guru')->get();
        } else {
            $institutions = collect(); // Admin tidak perlu pilih institusi
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

            // Validasi bahwa student & mentor dari institusi yang sama
            $studentInst = User::where('id', $data['student_id'])
                ->where('institution_id', $admin->institution_id)->exists();
            $mentorInst = User::where('id', $data['mentor_id'])
                ->where('institution_id', $admin->institution_id)->exists();

            if (!$studentInst || !$mentorInst) {
                return back()->withErrors(['authorization' => 'Siswa atau mentor bukan dari institusi Anda.'])->withInput();
            }
        }

        Placement::create($data);

        return redirect()->route('placements.index')->with('success', 'Placement berhasil dibuat.');
    }

    public function edit(Placement $placement)
    {
        $this->authorizePlacement($placement);

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
        $this->authorizePlacement($placement);

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

            $studentInst = User::where('id', $data['student_id'])
                ->where('institution_id', $admin->institution_id)->exists();
            $mentorInst = User::where('id', $data['mentor_id'])
                ->where('institution_id', $admin->institution_id)->exists();

            if (!$studentInst || !$mentorInst) {
                return back()->withErrors(['authorization' => 'Siswa atau mentor bukan dari institusi Anda.'])->withInput();
            }
        }

        $placement->update($data);

        return redirect()->route('placements.index')->with('success', 'Placement berhasil diperbarui.');
    }

    public function delete(Placement $placement)
    {
        $this->authorizePlacement($placement);

        $placement->delete();

        return redirect()->route('placements.index')->with('success', 'Placement berhasil dihapus.');
    }

    /**
     * Pastikan placement yang diakses berasal dari institusi yang sama
     */
    private function authorizePlacement(Placement $placement)
    {
        if (auth()->user()->role === 'superadmin') {
            return;
        }

        if ($placement->institution_id !== auth()->user()->institution_id) {
            abort(403, 'Anda tidak memiliki akses ke placement ini.');
        }
    }
}
