<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Placement;

class AttendanceController extends Controller
{
    /**
     * Check-in: murid menekan tombol di halaman placement detail
     */
    public function checkIn(Placement $placement)
    {
        $user = auth()->user();

        // Pastikan placement milik murid ini
        if ($placement->student_id !== $user->id) {
            abort(403, 'Ini bukan placement Anda.');
        }

        // Cek apakah sudah check-in hari ini
        $existing = Attendance::where('placement_id', $placement->id)
            ->where('date', now()->toDateString())->first();

        if ($existing) {
            return redirect()->route('placements.show', $placement)
                ->with('error', 'Anda sudah check-in hari ini.');
        }

        Attendance::create([
            'placement_id' => $placement->id,
            'date' => now()->toDateString(),
            'status' => 'hadir',
            'clock_in' => now()->format('H:i:s'),
            'clock_out' => null,
            'notes' => null,
        ]);

        return redirect()->route('placements.show', $placement)
            ->with('success', 'Check-in berhasil pada ' . now()->format('H:i') . '.');
    }

    /**
     * Check-out: murid menekan tombol setelah check-in
     */
    public function checkOut(Attendance $attendance)
    {
        $user = auth()->user();

        // Pastikan attendance ini milik murid via placement
        if ($attendance->placement->student_id !== $user->id) {
            abort(403, 'Ini bukan attendance Anda.');
        }

        if ($attendance->clock_out) {
            return redirect()->route('placements.show', $attendance->placement_id)
                ->with('error', 'Anda sudah check-out hari ini.');
        }

        $attendance->update([
            'clock_out' => now()->format('H:i:s'),
        ]);

        return redirect()->route('placements.show', $attendance->placement_id)
            ->with('success', 'Check-out berhasil pada ' . now()->format('H:i') . '.');
    }
}