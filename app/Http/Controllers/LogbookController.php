<?php

namespace App\Http\Controllers;

use App\Models\Logbook;
use App\Models\Placement;

class LogbookController extends Controller
{
    public function index()
    {
        $logbooks = Logbook::with(['placement.user', 'placement.institution'])->get();
        return view('logbooks.index', ['logbooks' => $logbooks]);
    }

    public function show(Logbook $logbook)
    {
        $logbook->load(['placement.user', 'placement.institution']);
        return view('logbooks.view', ['logbook' => $logbook]);
    }

    public function create()
    {
        $title = "Add new logbook entry";
        $placements = Placement::with(['user', 'institution'])->get();
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

        Logbook::create($data);
        return redirect()->route('logbooks.index')->with('success', 'Logbook entry created successfully.');
    }

    public function edit(Logbook $logbook)
    {
        $title = "Edit logbook entry";
        $placements = Placement::with(['user', 'institution'])->get();
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
