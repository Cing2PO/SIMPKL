<?php

namespace App\Http\Controllers;

use App\Models\Logbook;

class LogbookController extends Controller
{
    public function index()
    {
        $logbooks = Logbook::all();
        return view('logbooks.index', ['logbooks' => $logbooks]);
    }
}
