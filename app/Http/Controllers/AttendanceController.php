<?php

namespace App\Http\Controllers;

use App\Models\Attendance;

class AttendanceController extends Controller
{
    public function index()
    {
        $attendances = Attendance::all();
        return view('attendances.index', ['attendances' => $attendances]);
    }
}
