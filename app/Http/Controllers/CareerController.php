<?php

namespace App\Http\Controllers;

use App\Models\Career;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CareerController extends Controller
{
    public function index()
    {
        $careers = Career::orderBy('start_date', 'desc')->paginate(10);
        return view('careers.index', compact('careers'));
    }

    public function create()
    {
        return view('careers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'institution' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'current' => 'boolean',
            'degree' => 'nullable|string|max:255',
            'field_of_study' => 'nullable|string|max:255',
            'achievements' => 'nullable|string',
            'website' => 'nullable|url|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $career = new Career();
        $career->fill($request->except('logo'));

        if ($request->hasFile('logo')) {
            $path = $request->file('logo')->store('careers', 'public');
            $career->logo = $path;
        }

        $career->save();

        return redirect()
            ->route('careers.index')
            ->with('success', 'Carrera/Educación creada correctamente');
    }

    public function edit(Career $career)
    {
        return view('careers.edit', compact('career'));
    }

    public function update(Request $request, Career $career)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'institution' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'description' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after:start_date',
            'current' => 'boolean',
            'degree' => 'nullable|string|max:255',
            'field_of_study' => 'nullable|string|max:255',
            'achievements' => 'nullable|string',
            'website' => 'nullable|url|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        $career->fill($request->except('logo'));

        if ($request->hasFile('logo')) {
            if ($career->logo) {
                Storage::delete('public/' . $career->logo);
            }
            $path = $request->file('logo')->store('careers', 'public');
            $career->logo = $path;
        }

        $career->save();

        return redirect()
            ->route('careers.index')
            ->with('success', 'Carrera/Educación actualizada correctamente');
    }

    public function destroy(Career $career)
    {
        if ($career->logo) {
            Storage::delete('public/' . $career->logo);
        }

        $career->delete();

        return redirect()
            ->route('careers.index')
            ->with('success', 'Carrera/Educación eliminada correctamente');
    }

    public function show(Career $career)
    {
        return view('careers.show', compact('career'));
    }
}
