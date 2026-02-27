<?php

namespace App\Http\Controllers;

use App\Models\Institution;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules\Unique;

class InstitutionController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');

        $query = Institution::query();

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('contact_email', 'like', "%{$search}%");
            });
        }

        if ($status) {
            $query->where('status', $status);
        }

        $institutions = $query->paginate(10)->appends($request->query());
        return view('institutions.index', ['institutions' => $institutions]);
    }

    public function show(Institution $institution)
    {
        return view('institutions.view', ['institution' => $institution]);
    }

    public function create()
    {
        $title = "Add new institution";
        return view('institutions.create', ['title' => $title]);
    }

    public function store()
    {
        $data = request()->validate([
            'name' => 'required',
            'address' => 'required',
            'contact_email' => 'required|email|unique:institutions,contact_email',
            'contact_phone' => 'required',
            'status' => 'required|in:active,inactive',
        ]);

        Institution::create($data);
        return redirect()->route('institutions.index')->with('success', 'Institution created successfully.');
    }

    public function edit(Institution $institution)
    {
        $title = "Edit institution";
        return view('institutions.edit', ['institution' => $institution, 'title' => $title]);
    }

    public function update(Institution $institution)
    {
        $data = request()->validate([
            'name' => 'required',
            'address' => 'required',
            'contact_email' => 'required|email|unique:institutions,contact_email,' . $institution->id,
            'contact_phone' => 'required|unique:institutions,contact_phone,' . $institution->id,
            'status' => 'required|in:active,inactive',
        ]);

        $institution->update($data);
        return redirect()->route('institutions.index')->with('success', 'Institution updated successfully.');
    }

    public function delete(Institution $insitution)
    {
        $insitution->delete();
        return redirect()->route('institutions.index')->with('success', 'Institution deleted successfully.');
    }
}
