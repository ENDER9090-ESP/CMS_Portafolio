<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Tool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::with('tools')->orderBy('created_at', 'desc')->paginate(10);
        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        $tools = Tool::all();
        return view('projects.create', compact('tools'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'url' => 'nullable|url',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'required|in:in_progress,completed,on_hold',
            'tools' => 'array|exists:tools,id',
            'specific_uses' => 'array'
        ]);

        $project = new Project();
        $project->fill($request->except(['image', 'tools', 'specific_uses']));

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('projects', 'public');
            $project->image = $path;
        }

        $project->save();

        // Asociar herramientas con sus usos específicos
        if ($request->has('tools')) {
            $toolUses = [];
            foreach ($request->tools as $index => $toolId) {
                $toolUses[$toolId] = [
                    'specific_use' => $request->specific_uses[$index] ?? null
                ];
            }
            $project->tools()->sync($toolUses);
        }

        return redirect()
            ->route('projects.show', $project)
            ->with('success', 'Proyecto creado correctamente');
    }

    public function show(Project $project)
    {
        $project->load('tools');
        return view('projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        $tools = Tool::all();
        $project->load('tools');
        return view('projects.edit', compact('project', 'tools'));
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'url' => 'nullable|url',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'required|in:in_progress,completed,on_hold',
            'tools' => 'array|exists:tools,id',
            'specific_uses' => 'array'
        ]);

        $project->fill($request->except(['image', 'tools', 'specific_uses']));

        if ($request->hasFile('image')) {
            // Eliminar imagen anterior si existe
            if ($project->image) {
                Storage::delete('public/' . $project->image);
            }
            
            $path = $request->file('image')->store('projects', 'public');
            $project->image = $path;
        }

        $project->save();

        // Actualizar herramientas con sus usos específicos
        if ($request->has('tools')) {
            $toolUses = [];
            foreach ($request->tools as $index => $toolId) {
                $toolUses[$toolId] = [
                    'specific_use' => $request->specific_uses[$index] ?? null
                ];
            }
            $project->tools()->sync($toolUses);
        }

        return redirect()
            ->route('projects.show', $project)
            ->with('success', 'Proyecto actualizado correctamente');
    }

    public function destroy(Project $project)
    {
        // Eliminar imagen si existe
        if ($project->image) {
            Storage::delete('public/' . $project->image);
        }

        // Eliminar proyecto y sus relaciones
        $project->tools()->detach();
        $project->delete();

        return redirect()
            ->route('projects.index')
            ->with('success', 'Proyecto eliminado correctamente');
    }
}
