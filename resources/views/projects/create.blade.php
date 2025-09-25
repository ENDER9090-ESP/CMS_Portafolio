@extends('layouts.app')

@section('title', 'Crear Proyecto')

@section('content')
<div class="bg-white shadow rounded-lg">
    <div class="p-6 border-b border-gray-200">
        <h2 class="text-2xl font-semibold text-gray-900">Crear Nuevo Proyecto</h2>
    </div>

    <form action="{{ route('projects.store') }}" method="POST" enctype="multipart/form-data" class="p-6 space-y-6">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Información básica -->
            <div class="space-y-6">
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">Título del Proyecto</label>
                    <input type="text" name="title" id="title" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="{{ old('title') }}" required>
                </div>

                <div>
                    <label for="url" class="block text-sm font-medium text-gray-700">URL del Proyecto</label>
                    <input type="url" name="url" id="url" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="{{ old('url') }}">
                </div>

                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700">Fecha de Inicio</label>
                    <input type="date" name="start_date" id="start_date" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="{{ old('start_date') }}" required>
                </div>

                <div>
                    <label for="end_date" class="block text-sm font-medium text-gray-700">Fecha de Finalización</label>
                    <input type="date" name="end_date" id="end_date" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md" value="{{ old('end_date') }}">
                </div>

                <div>
                    <label for="status" class="block text-sm font-medium text-gray-700">Estado</label>
                    <select name="status" id="status" class="mt-1 block w-full pl-3 pr-10 py-2 text-base border-gray-300 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm rounded-md">
                        <option value="in_progress" {{ old('status') == 'in_progress' ? 'selected' : '' }}>En Progreso</option>
                        <option value="completed" {{ old('status') == 'completed' ? 'selected' : '' }}>Completado</option>
                        <option value="on_hold" {{ old('status') == 'on_hold' ? 'selected' : '' }}>En Pausa</option>
                    </select>
                </div>
            </div>

            <!-- Descripción y herramientas -->
            <div class="space-y-6">
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">Descripción</label>
                    <textarea name="description" id="description" rows="4" class="mt-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">{{ old('description') }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Imagen del Proyecto</label>
                    <input type="file" name="image" id="image" class="focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300">
                    <p class="mt-1 text-sm text-gray-500">PNG, JPG hasta 2MB</p>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">Herramientas Utilizadas</label>
                    <div class="space-y-2">
                        @foreach($tools as $tool)
                            <div class="flex items-center space-x-3">
                                <input type="checkbox" name="tools[]" value="{{ $tool->id }}" class="focus:ring-indigo-500 h-4 w-4 text-indigo-600 border-gray-300 rounded" {{ in_array($tool->id, old('tools', [])) ? 'checked' : '' }}>
                                <input type="text" name="specific_uses[]" placeholder="¿Cómo se usó {{ $tool->name }}?" class="flex-1 focus:ring-indigo-500 focus:border-indigo-500 block w-full shadow-sm sm:text-sm border-gray-300 rounded-md">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-6 border-t border-gray-200">
            <div class="flex justify-end">
                <a href="{{ route('projects.index') }}" class="bg-white py-2 px-4 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Cancelar
                </a>
                <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Crear Proyecto
                </button>
            </div>
        </div>
    </form>
</div>
@endsection