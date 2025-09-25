@extends('layouts.app')

@section('title', 'Proyectos')

@section('content')
<div class="space-y-6">
    <!-- Encabezado -->
    <div class="flex justify-between items-center">
        <h2 class="text-2xl font-bold text-gray-800">Proyectos</h2>
        <a href="{{ route('projects.create') }}" 
           class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition duration-200">
            <i class="fas fa-plus mr-2"></i> Nuevo Proyecto
        </a>
    </div>

    <!-- Lista de Proyectos -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($projects ?? [] as $project)
        <div class="bg-white rounded-lg shadow-sm overflow-hidden">
            <!-- Imagen del Proyecto -->
            <div class="aspect-w-16 aspect-h-9 bg-gray-200">
                @if($project->thumbnail)
                    <img src="{{ Storage::url($project->thumbnail) }}" 
                         alt="{{ $project->title }}" 
                         class="w-full h-full object-cover">
                @else
                    <div class="w-full h-full flex items-center justify-center">
                        <i class="fas fa-image text-4xl text-gray-400"></i>
                    </div>
                @endif
            </div>

            <!-- Contenido del Proyecto -->
            <div class="p-4">
                <div class="flex items-center justify-between mb-2">
                    <h3 class="text-lg font-semibold text-gray-800">{{ $project->title }}</h3>
                    <span class="px-2 py-1 text-xs rounded-full {{ $project->status == 'completado' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                        {{ ucfirst($project->status) }}
                    </span>
                </div>

                <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                    {{ $project->description }}
                </p>

                <!-- Tecnologías -->
                <div class="flex flex-wrap gap-2 mb-4">
                    @foreach($project->tools as $tool)
                    <span class="px-2 py-1 text-xs bg-gray-100 text-gray-600 rounded">
                        {{ $tool->name }}
                    </span>
                    @endforeach
                </div>

                <!-- Enlaces -->
                <div class="flex items-center space-x-4 text-sm">
                    @if($project->project_url)
                    <a href="{{ $project->project_url }}" target="_blank" 
                       class="text-blue-600 hover:text-blue-800">
                        <i class="fas fa-link mr-1"></i> Demo
                    </a>
                    @endif

                    @if($project->github_url)
                    <a href="{{ $project->github_url }}" target="_blank"
                       class="text-gray-600 hover:text-gray-800">
                        <i class="fab fa-github mr-1"></i> GitHub
                    </a>
                    @endif
                </div>

                <!-- Acciones -->
                <div class="mt-4 flex justify-end space-x-2">
                    <a href="{{ route('projects.edit', $project) }}" 
                       class="text-blue-600 hover:text-blue-800">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ route('projects.destroy', $project) }}" method="POST" 
                          onsubmit="return confirm('¿Estás seguro de que deseas eliminar este proyecto?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="text-red-600 hover:text-red-800">
                            <i class="fas fa-trash"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-full">
            <div class="text-center py-12 bg-white rounded-lg">
                <i class="fas fa-project-diagram text-4xl text-gray-400 mb-4"></i>
                <h3 class="text-lg font-medium text-gray-900">No hay proyectos</h3>
                <p class="mt-2 text-sm text-gray-500">Comienza agregando tu primer proyecto.</p>
                <div class="mt-6">
                    <a href="{{ route('projects.create') }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                        <i class="fas fa-plus mr-2"></i> Nuevo Proyecto
                    </a>
                </div>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Paginación -->
    @if(isset($projects) && $projects->hasPages())
    <div class="mt-6">
        {{ $projects->links() }}
    </div>
    @endif
</div>
@endsection