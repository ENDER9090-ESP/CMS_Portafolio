@extends('layouts.app')

@section('title', $tool->name)

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-semibold text-gray-900">{{ $tool->name }}</h2>
        <div class="flex space-x-3">
            <a href="{{ route('tools.edit', $tool) }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700">
                <i class="fas fa-edit mr-2"></i>
                Editar
            </a>
            <a href="{{ route('tools.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                <i class="fas fa-arrow-left mr-2"></i>
                Volver
            </a>
        </div>
    </div>

    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <div class="flex items-center">
                @if($tool->icon)
                    <img src="{{ Storage::url($tool->icon) }}" alt="{{ $tool->name }}" class="h-12 w-12 object-contain mr-4">
                @else
                    <div class="h-12 w-12 rounded bg-gray-200 flex items-center justify-center mr-4">
                        <i class="fas fa-tools text-gray-400 text-xl"></i>
                    </div>
                @endif
                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Detalles de la Herramienta</h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">
                        Información completa sobre {{ $tool->name }}
                    </p>
                </div>
            </div>
        </div>
        <div class="border-t border-gray-200">
            <dl>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Nombre</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $tool->name }}</dd>
                </div>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Categoría</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        <span class="px-2.5 py-0.5 rounded-full text-xs font-medium {{ $tool->category === 'programming_language' ? 'bg-blue-100 text-blue-800' : ($tool->category === 'framework' ? 'bg-green-100 text-green-800' : 'bg-purple-100 text-purple-800') }}">
                            {{ ucfirst(str_replace('_', ' ', $tool->category)) }}
                        </span>
                    </dd>
                </div>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Descripción</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $tool->description }}</dd>
                </div>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Nivel de Competencia</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        <div class="flex items-center">
                            @for($i = 1; $i <= 5; $i++)
                                <i class="fas fa-star {{ $i <= $tool->proficiency_level ? 'text-yellow-400' : 'text-gray-300' }} mr-1"></i>
                            @endfor
                            <span class="ml-2">
                                {{ $tool->proficiency_level }} - 
                                {{ ['Principiante', 'Básico', 'Intermedio', 'Avanzado', 'Experto'][$tool->proficiency_level-1] }}
                            </span>
                        </div>
                    </dd>
                </div>
            </dl>
        </div>
    </div>

    <!-- Sección de Proyectos -->
    @if($tool->projects->count() > 0)
        <div class="mt-8">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Proyectos que utilizan esta herramienta</h3>
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <ul class="divide-y divide-gray-200">
                    @foreach($tool->projects as $project)
                        <li class="px-4 py-4 hover:bg-gray-50">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    @if($project->image)
                                        <img src="{{ Storage::url($project->image) }}" alt="{{ $project->title }}" class="h-10 w-10 object-cover rounded">
                                    @else
                                        <div class="h-10 w-10 rounded bg-gray-200 flex items-center justify-center">
                                            <i class="fas fa-project-diagram text-gray-400"></i>
                                        </div>
                                    @endif
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">{{ $project->title }}</p>
                                        <p class="text-sm text-gray-500">{{ Str::limit($project->description, 100) }}</p>
                                    </div>
                                </div>
                                <a href="{{ route('projects.show', $project) }}" class="text-indigo-600 hover:text-indigo-900">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif

    <!-- Sección de Certificados -->
    @if($tool->certificates->count() > 0)
        <div class="mt-8">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Certificados relacionados con esta herramienta</h3>
            <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                <ul class="divide-y divide-gray-200">
                    @foreach($tool->certificates as $certificate)
                        <li class="px-4 py-4 hover:bg-gray-50">
                            <div class="flex items-center justify-between">
                                <div class="flex items-center">
                                    @if($certificate->image)
                                        <img src="{{ Storage::url($certificate->image) }}" alt="{{ $certificate->title }}" class="h-10 w-10 object-cover rounded">
                                    @else
                                        <div class="h-10 w-10 rounded bg-gray-200 flex items-center justify-center">
                                            <i class="fas fa-certificate text-gray-400"></i>
                                        </div>
                                    @endif
                                    <div class="ml-3">
                                        <p class="text-sm font-medium text-gray-900">{{ $certificate->title }}</p>
                                        <p class="text-sm text-gray-500">{{ $certificate->issuing_organization }} - {{ $certificate->issue_date->format('d/m/Y') }}</p>
                                    </div>
                                </div>
                                <a href="{{ route('certificates.show', $certificate) }}" class="text-indigo-600 hover:text-indigo-900">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
</div>
@endsection