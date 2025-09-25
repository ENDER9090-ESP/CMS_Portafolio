@extends('layouts.app')

@section('title', $career->title)

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-semibold text-gray-900">{{ $career->title }}</h2>
        <div class="flex space-x-3">
            <a href="{{ route('careers.edit', $career) }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                <i class="fas fa-edit mr-2"></i>
                Editar
            </a>
            <a href="{{ route('careers.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                <i class="fas fa-arrow-left mr-2"></i>
                Volver
            </a>
        </div>
    </div>

    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <div class="flex items-center">
                @if($career->logo)
                    <img src="{{ Storage::url($career->logo) }}" alt="{{ $career->institution }}" class="h-24 w-24 object-contain mr-6">
                @endif
                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Detalles de la Carrera/Educación</h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">
                        {{ $career->institution }}
                    </p>
                </div>
            </div>
        </div>
        <div class="border-t border-gray-200">
            <dl>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Título/Rol</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $career->title }}</dd>
                </div>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Institución</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $career->institution }}
                        @if($career->website)
                            <br>
                            <a href="{{ $career->website }}" target="_blank" class="text-indigo-600 hover:text-indigo-900">
                                Visitar sitio web <i class="fas fa-external-link-alt ml-1"></i>
                            </a>
                        @endif
                    </dd>
                </div>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Ubicación</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $career->location }}</dd>
                </div>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Período</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                        {{ $career->start_date->format('F Y') }} - 
                        {{ $career->current ? 'Presente' : $career->end_date->format('F Y') }}
                    </dd>
                </div>
                @if($career->degree || $career->field_of_study)
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Título/Campo de Estudio</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            {{ $career->degree }}
                            @if($career->field_of_study)
                                en {{ $career->field_of_study }}
                            @endif
                        </dd>
                    </div>
                @endif
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Descripción</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $career->description }}</dd>
                </div>
                @if($career->achievements)
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Logros</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $career->achievements }}</dd>
                    </div>
                @endif
            </dl>
        </div>
    </div>
</div>
@endsection