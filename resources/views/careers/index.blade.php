@extends('layouts.app')

@section('title', 'Carreras y Educación')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-900">Carreras y Educación</h2>
        <a href="{{ route('careers.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700">
            <i class="fas fa-plus mr-2"></i>
            Nueva Entrada
        </a>
    </div>

    @if($careers->count() > 0)
        <div class="space-y-6">
            @foreach($careers as $career)
                <div class="bg-white shadow overflow-hidden sm:rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-start">
                            @if($career->logo)
                                <img src="{{ Storage::url($career->logo) }}" alt="{{ $career->institution }}" class="h-16 w-16 object-contain rounded-lg">
                            @else
                                <div class="h-16 w-16 rounded-lg bg-gray-200 flex items-center justify-center">
                                    <i class="fas fa-graduation-cap text-gray-400 text-2xl"></i>
                                </div>
                            @endif
                            <div class="ml-6 flex-1">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="text-lg font-medium text-gray-900">{{ $career->title }}</h3>
                                        <p class="mt-1 text-sm text-gray-600">{{ $career->institution }}</p>
                                    </div>
                                    <div class="flex items-center space-x-4">
                                        <a href="{{ route('careers.edit', $career) }}" class="text-indigo-600 hover:text-indigo-900">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="{{ route('careers.destroy', $career) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de querer eliminar esta entrada?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-900">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <p class="text-sm text-gray-500">
                                        <i class="fas fa-map-marker-alt mr-2"></i>
                                        {{ $career->location }}
                                    </p>
                                    <p class="text-sm text-gray-500">
                                        <i class="far fa-calendar-alt mr-2"></i>
                                        {{ $career->start_date->format('M Y') }} - 
                                        {{ $career->current ? 'Presente' : $career->end_date->format('M Y') }}
                                    </p>
                                </div>
                                @if($career->degree || $career->field_of_study)
                                    <p class="mt-2 text-sm text-gray-600">
                                        {{ $career->degree }}
                                        @if($career->field_of_study)
                                            en {{ $career->field_of_study }}
                                        @endif
                                    </p>
                                @endif
                                <p class="mt-2 text-sm text-gray-600">{{ Str::limit($career->description, 200) }}</p>
                                @if($career->website)
                                    <div class="mt-2">
                                        <a href="{{ $career->website }}" target="_blank" class="inline-flex items-center text-sm text-indigo-600 hover:text-indigo-900">
                                            <i class="fas fa-external-link-alt mr-1"></i>
                                            Sitio Web
                                        </a>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach

            <div class="mt-6">
                {{ $careers->links() }}
            </div>
        </div>
    @else
        <div class="text-center py-12 bg-white rounded-lg shadow-sm">
            <i class="fas fa-graduation-cap text-gray-400 text-4xl mb-4"></i>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No hay entradas registradas</h3>
            <p class="text-gray-500 mb-6">Comienza añadiendo tu primera carrera o educación</p>
            <a href="{{ route('careers.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700">
                <i class="fas fa-plus mr-2"></i>
                Nueva Entrada
            </a>
        </div>
    @endif
</div>
@endsection