<?php

namespace App\Http\Controllers;

use App\Models\Tool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ToolController extends Controller
{
    public function index()
    {
        $tools = Tool::withCount(['projects', 'certificates'])
            ->orderBy('name')
            ->paginate(15);
        return view('tools.index', compact('tools'));
    }

    public function create()
    {
        $categories = [
            'programming_language' => 'Lenguaje de Programación',
            'framework' => 'Framework',
            'database' => 'Base de Datos',
            'tool' => 'Herramienta',
            'platform' => 'Plataforma',
            'other' => 'Otro'
        ];
        
        return view('tools.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:tools',
            'category' => 'required|string|in:programming_language,framework,database,tool,platform,other',
            'description' => 'required|string',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:1024',
            'proficiency_level' => 'required|integer|min:1|max:5'
        ]);

        $tool = new Tool();
        $tool->fill($request->except('icon'));

        if ($request->hasFile('icon')) {
            $path = $request->file('icon')->store('tools', 'public');
            $tool->icon = $path;
        }

        $tool->save();

        return redirect()
            ->route('tools.index')
            ->with('success', 'Herramienta creada correctamente');
    }

    public function show(Tool $tool)
    {
        $tool->load(['projects', 'certificates']);
        return view('tools.show', compact('tool'));
    }

    public function edit(Tool $tool)
    {
        $categories = [
            'programming_language' => 'Lenguaje de Programación',
            'framework' => 'Framework',
            'database' => 'Base de Datos',
            'tool' => 'Herramienta',
            'platform' => 'Plataforma',
            'other' => 'Otro'
        ];
        
        return view('tools.edit', compact('tool', 'categories'));
    }

    public function update(Request $request, Tool $tool)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:tools,name,' . $tool->id,
            'category' => 'required|string|in:programming_language,framework,database,tool,platform,other',
            'description' => 'required|string',
            'icon' => 'nullable|image|mimes:jpeg,png,jpg,svg|max:1024',
            'proficiency_level' => 'required|integer|min:1|max:5'
        ]);

        $tool->fill($request->except('icon'));

        if ($request->hasFile('icon')) {
            // Eliminar icono anterior si existe
            if ($tool->icon) {
                Storage::delete('public/' . $tool->icon);
            }
            
            $path = $request->file('icon')->store('tools', 'public');
            $tool->icon = $path;
        }

        $tool->save();

        return redirect()
            ->route('tools.index')
            ->with('success', 'Herramienta actualizada correctamente');
    }

    public function destroy(Tool $tool)
    {
        // Verificar si la herramienta está en uso
        if ($tool->projects()->count() > 0 || $tool->certificates()->count() > 0) {
            return back()->with('error', 'No se puede eliminar la herramienta porque está siendo utilizada en proyectos o certificados.');
        }

        // Eliminar icono si existe
        if ($tool->icon) {
            Storage::delete('public/' . $tool->icon);
        }

        $tool->delete();

        return redirect()
            ->route('tools.index')
            ->with('success', 'Herramienta eliminada correctamente');
    }

    public function usage(Tool $tool)
    {
        $tool->load(['projects', 'certificates']);
        return view('tools.usage', compact('tool'));
    }
}
