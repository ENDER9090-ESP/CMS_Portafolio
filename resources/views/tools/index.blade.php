@extends('layouts.app')

@section('title', 'Herramientas')

@section('content')
<div class="mb-6 flex justify-between items-center">
    <h2 class="text-2xl font-semibold text-gray-900">Herramientas</h2>
    <a href="{{ route('tools.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700">
        <i class="fas fa-plus mr-2"></i>
        Nueva Herramienta
    </a>
</div>

<div class="bg-white shadow overflow-hidden sm:rounded-lg">
    @if($tools->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 p-6">
            @foreach($tools as $tool)
                <div class="bg-white rounded-lg border shadow-sm hover:shadow-md transition-shadow duration-200">
                    <div class="p-4">
                        <div class="flex items-center justify-between mb-4">
                            <div class="flex items-center">
                                @if($tool->icon)
                                    <img src="{{ Storage::url($tool->icon) }}" alt="{{ $tool->name }}" class="w-8 h-8 object-contain">
                                @else
                                    <div class="w-8 h-8 rounded bg-gray-200 flex items-center justify-center">
                                        <i class="fas fa-tools text-gray-400"></i>
                                    </div>
                                @endif
                                <h3 class="ml-3 text-lg font-medium text-gray-900">{{ $tool->name }}</h3>
                            </div>
                            <span class="px-2.5 py-0.5 rounded-full text-xs font-medium {{ $tool->category === 'programming_language' ? 'bg-blue-100 text-blue-800' : ($tool->category === 'framework' ? 'bg-green-100 text-green-800' : 'bg-purple-100 text-purple-800') }}">
                                {{ ucfirst(str_replace('_', ' ', $tool->category)) }}
                            </span>
                        </div>
                        
                        <p class="text-sm text-gray-600 mb-4">{{ Str::limit($tool->description, 100) }}</p>
                        
                        <div class="flex items-center justify-between">
                            <div class="flex items-center text-sm text-gray-500">
                                <span class="mr-4">
                                    <i class="fas fa-project-diagram mr-1"></i>
                                    {{ $tool->projects_count }} proyectos
                                </span>
                                <span>
                                    <i class="fas fa-certificate mr-1"></i>
                                    {{ $tool->certificates_count }} certificados
                                </span>
                            </div>
                            
                            <div class="flex space-x-2">
                                <a href="{{ route('tools.edit', $tool) }}" class="text-indigo-600 hover:text-indigo-900">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('tools.destroy', $tool) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de querer eliminar esta herramienta?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="p-6 border-t border-gray-200">
            {{ $tools->links() }}
        </div>
    @else
        <div class="p-6 text-center text-gray-500">
            <i class="fas fa-tools text-4xl mb-4"></i>
            <p>No hay herramientas registradas aún.</p>
            <a href="{{ route('tools.create') }}" class="mt-4 inline-flex items-center text-sm text-indigo-600 hover:text-indigo-500">
                Registra tu primera herramienta <span class="ml-1">→</span>
            </a>
        </div>
    @endif
</div>
@endsection