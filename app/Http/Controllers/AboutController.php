<?php

namespace App\Http\Controllers;

use App\Models\AboutMe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AboutController extends Controller
{
    public function edit()
    {
        $about = AboutMe::first() ?? new AboutMe();
        return view('about.edit', compact('about'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'location' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'cv' => 'nullable|mimes:pdf|max:5120',
            'linkedin' => 'nullable|url|max:255',
            'github' => 'nullable|url|max:255',
            'twitter' => 'nullable|url|max:255',
            'website' => 'nullable|url|max:255'
        ]);

        $about = AboutMe::first() ?? new AboutMe();
        $about->fill($request->except(['photo', 'cv']));

        if ($request->hasFile('photo')) {
            if ($about->photo) {
                Storage::delete('public/' . $about->photo);
            }
            $path = $request->file('photo')->store('about', 'public');
            $about->photo = $path;
        }

        if ($request->hasFile('cv')) {
            if ($about->cv) {
                Storage::delete('public/' . $about->cv);
            }
            $path = $request->file('cv')->store('cv', 'public');
            $about->cv = $path;
        }

        $about->save();

        return redirect()
            ->route('about.edit')
            ->with('success', 'Información actualizada correctamente');
    }
}
