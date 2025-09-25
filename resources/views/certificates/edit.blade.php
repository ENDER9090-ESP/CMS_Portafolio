@extends('layouts.app')

@section('title', 'Editar Certificado')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-semibold text-gray-900">Editar Certificado</h2>
        <a href="{{ route('certificates.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
            <i class="fas fa-arrow-left mr-2"></i>
            Volver
        </a>
    </div>

    <div class="bg-white shadow rounded-lg">
        <form action="{{ route('certificates.update', $certificate) }}" method="POST" enctype="multipart/form-data" class="space-y-6 p-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">Título</label>
                    <input type="text" name="title" id="title" value="{{ old('title', $certificate->title) }}" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    @error('title')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>

                <div>
                    <label for="issuing_organization" class="block text-sm font-medium text-gray-700">Organización Emisora</label>
                    <input type="text" name="issuing_organization" id="issuing_organization" value="{{ old('issuing_organization', $certificate->issuing_organization) }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    @error('issuing_organization')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>

                <div>
                    <label for="issue_date" class="block text-sm font-medium text-gray-700">Fecha de Emisión</label>
                    <input type="date" name="issue_date" id="issue_date" value="{{ old('issue_date', $certificate->issue_date->format('Y-m-d')) }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    @error('issue_date')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>

                <div>
                    <label for="expiry_date" class="block text-sm font-medium text-gray-700">Fecha de Expiración</label>
                    <input type="date" name="expiry_date" id="expiry_date" value="{{ old('expiry_date', $certificate->expiry_date?->format('Y-m-d')) }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('expiry_date')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>

                <div>
                    <label for="credential_id" class="block text-sm font-medium text-gray-700">ID de Credencial</label>
                    <input type="text" name="credential_id" id="credential_id" value="{{ old('credential_id', $certificate->credential_id) }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('credential_id')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>

                <div>
                    <label for="credential_url" class="block text-sm font-medium text-gray-700">URL de Credencial</label>
                    <input type="url" name="credential_url" id="credential_url" value="{{ old('credential_url', $certificate->credential_url) }}"
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @error('credential_url')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>

                <div>
                    <label for="image" class="block text-sm font-medium text-gray-700">Imagen del Certificado</label>
                    @if($certificate->image)
                        <div class="mt-2 mb-4">
                            <img src="{{ Storage::url($certificate->image) }}" alt="{{ $certificate->title }}" class="h-32 w-auto object-contain">
                        </div>
                    @endif
                    <input type="file" name="image" id="image" accept="image/*"
                        class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                    @error('image')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>

                <div class="md:col-span-2">
                    <label for="tools" class="block text-sm font-medium text-gray-700 mb-2">Herramientas/Tecnologías Relacionadas</label>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                        @foreach($tools as $tool)
                            <div class="flex items-center">
                                <input type="checkbox" name="tools[]" value="{{ $tool->id }}" id="tool_{{ $tool->id }}"
                                    class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"
                                    {{ in_array($tool->id, old('tools', $certificate->tools->pluck('id')->toArray())) ? 'checked' : '' }}>
                                <label for="tool_{{ $tool->id }}" class="ml-2 block text-sm text-gray-900">
                                    {{ $tool->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                    @error('tools')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>

                <div class="md:col-span-2">
                    <label for="description" class="block text-sm font-medium text-gray-700">Descripción</label>
                    <textarea name="description" id="description" rows="4" 
                        class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>{{ old('description', $certificate->description) }}</textarea>
                    @error('description')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
                </div>
            </div>

            <div class="flex justify-end space-x-3">
                <a href="{{ route('certificates.index') }}" 
                    class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Cancelar
                </a>
                <button type="submit" 
                    class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Actualizar
                </button>
            </div>
        </form>
    </div>
</div>
@endsection