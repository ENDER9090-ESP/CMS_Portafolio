<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\Tool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CertificateController extends Controller
{
    public function index()
    {
        $certificates = Certificate::with('tools')
            ->orderBy('issue_date', 'desc')
            ->paginate(12);
            
        return view('certificates.index', compact('certificates'));
    }

    public function create()
    {
        $tools = Tool::orderBy('name')->get();
        return view('certificates.create', compact('tools'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'issuing_organization' => 'required|string|max:255',
            'issue_date' => 'required|date',
            'expiry_date' => 'nullable|date|after:issue_date',
            'credential_id' => 'nullable|string|max:255',
            'credential_url' => 'nullable|url|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'tools' => 'nullable|array',
            'tools.*' => 'exists:tools,id'
        ]);

        $certificate = new Certificate();
        $certificate->fill($request->except(['image', 'tools']));

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('certificates', 'public');
            $certificate->image = $path;
        }

        $certificate->save();

        if ($request->has('tools')) {
            $certificate->tools()->sync($request->tools);
        }

        return redirect()
            ->route('certificates.index')
            ->with('success', 'Certificado creado correctamente');
    }

    public function edit(Certificate $certificate)
    {
        $tools = Tool::orderBy('name')->get();
        $certificate->load('tools');
        return view('certificates.edit', compact('certificate', 'tools'));
    }

    public function update(Request $request, Certificate $certificate)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'issuing_organization' => 'required|string|max:255',
            'issue_date' => 'required|date',
            'expiry_date' => 'nullable|date|after:issue_date',
            'credential_id' => 'nullable|string|max:255',
            'credential_url' => 'nullable|url|max:255',
            'description' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'tools' => 'nullable|array',
            'tools.*' => 'exists:tools,id'
        ]);

        $certificate->fill($request->except(['image', 'tools']));

        if ($request->hasFile('image')) {
            if ($certificate->image) {
                Storage::delete('public/' . $certificate->image);
            }
            $path = $request->file('image')->store('certificates', 'public');
            $certificate->image = $path;
        }

        $certificate->save();

        if ($request->has('tools')) {
            $certificate->tools()->sync($request->tools);
        }

        return redirect()
            ->route('certificates.index')
            ->with('success', 'Certificado actualizado correctamente');
    }

    public function destroy(Certificate $certificate)
    {
        if ($certificate->image) {
            Storage::delete('public/' . $certificate->image);
        }

        $certificate->tools()->detach();
        $certificate->delete();

        return redirect()
            ->route('certificates.index')
            ->with('success', 'Certificado eliminado correctamente');
    }

    public function show(Certificate $certificate)
    {
        $certificate->load('tools');
        return view('certificates.show', compact('certificate'));
    }
}
