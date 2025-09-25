@extends('layouts.app')

@section('title', 'Nueva Entrada de Carrera/Educación')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-semibold text-gray-900">Nueva Entrada de Carrera/Educación</h2>
        <a href="{{ route('careers.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
            <i class="fas fa-arrow-left mr-2"></i>
            Volver
        </a>
    </div>

    <div class="bg-white shadow rounded-lg">
        <form action="{{ route('careers.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6 p-6">
            @csrf

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">Título/Rol</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    @error('title')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>

                <div>
                    <label for="institution" class="block text-sm font-medium text-gray-700">Institución</label>
                    <input type="text" name="institution" id="institution" value="{{ old('institution') }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    @error('institution')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>

                <div>
                    <label for="location" class="block text-sm font-medium text-gray-700">Ubicación</label>
                    <input type="text" name="location" id="location" value="{{ old('location') }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    @error('location')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>

                <div>
                    <label for="website" class="block text-sm font-medium text-gray-700">Sitio Web</label>
                    <input type="url" name="website" id="website" value="{{ old('website') }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('website')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>

                <div>
                    <label for="start_date" class="block text-sm font-medium text-gray-700">Fecha de Inicio</label>
                    <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    @error('start_date')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>

                <div class="relative">
                    <div class="flex items-center mb-4">
                        <input type="checkbox" name="current" id="current" value="1" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                            {{ old('current') ? 'checked' : '' }} onchange="toggleEndDate(this)">
                        <label for="current" class="ml-2 block text-sm text-gray-900">
                            Actualmente en curso
                        </label>
                    </div>
                    <div id="end_date_container" class="{{ old('current') ? 'hidden' : '' }}">
                        <label for="end_date" class="block text-sm font-medium text-gray-700">Fecha de Fin</label>
                        <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}"
                            class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                        @error('end_date')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                    </div>
                </div>

                <div>
                    <label for="degree" class="block text-sm font-medium text-gray-700">Título/Grado</label>
                    <input type="text" name="degree" id="degree" value="{{ old('degree') }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('degree')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>

                <div>
                    <label for="field_of_study" class="block text-sm font-medium text-gray-700">Campo de Estudio</label>
                    <input type="text" name="field_of_study" id="field_of_study" value="{{ old('field_of_study') }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('field_of_study')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>

                <div class="md:col-span-2">
                    <label for="logo" class="block text-sm font-medium text-gray-700">Logo</label>
                    <input type="file" name="logo" id="logo" accept="image/*"
                        class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                    @error('logo')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>

                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700">Descripción</label>
                    <textarea name="description" id="description" rows="4" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>{{ old('description') }}</textarea>
                    @error('description')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>

                <div class="md:col-span-2">
                    <label for="achievements" class="block text-sm font-medium text-gray-700">Logros</label>
                    <textarea name="achievements" id="achievements" rows="4" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('achievements') }}</textarea>
                    @error('achievements')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('careers.index') }}" 
                    class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Cancelar
                </a>
                <button type="submit" 
                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Guardar
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
function toggleEndDate(checkbox) {
    const endDateContainer = document.getElementById('end_date_container');
    const endDateInput = document.getElementById('end_date');
    
    if (checkbox.checked) {
        endDateContainer.classList.add('hidden');
        endDateInput.value = '';
    } else {
        endDateContainer.classList.remove('hidden');
    }
}
</script>
@endpush

@endsection