<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AboutMe;

class AboutMeController extends Controller
{
    public function index()
    {
        $aboutMe = AboutMe::first();
        return view('about.index', compact('aboutMe'));
    }

    public function edit()
    {
        $aboutMe = AboutMe::first();
        return view('about.edit', compact('aboutMe'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'description' => 'required',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $aboutMe = AboutMe::first();
        if (!$aboutMe) {
            $aboutMe = new AboutMe();
        }

        $aboutMe->description = $request->description;
        
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('uploads'), $filename);
            $aboutMe->photo = 'uploads/' . $filename;
        }

        $aboutMe->save();

        return redirect()->route('about.index')->with('success', 'Información actualizada exitosamente');
    }
}