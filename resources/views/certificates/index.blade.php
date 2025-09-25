@extends('layouts.app')

@section('title', 'Certificados')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-semibold text-gray-900">Certificados</h2>
        <a href="{{ route('certificates.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700">
            <i class="fas fa-plus mr-2"></i>
            Nuevo Certificado
        </a>
    </div>

    @if($certificates->count() > 0)
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($certificates as $certificate)
                <div class="bg-white rounded-lg shadow-sm hover:shadow-md transition-shadow duration-200">
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-4">
                            @if($certificate->image)
                                <img src="{{ Storage::url($certificate->image) }}" alt="{{ $certificate->title }}" class="w-16 h-16 object-cover rounded">
                            @else
                                <div class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center">
                                    <i class="fas fa-certificate text-gray-400 text-2xl"></i>
                                </div>
                            @endif
                            <div class="ml-4 flex-1">
                                <h3 class="text-lg font-medium text-gray-900">{{ $certificate->title }}</h3>
                                <p class="text-sm text-gray-500">{{ $certificate->issuing_organization }}</p>
                            </div>
                        </div>

                        <div class="mb-4">
                            <p class="text-sm text-gray-600">
                                <i class="far fa-calendar-alt mr-2"></i>
                                {{ $certificate->issue_date->format('d/m/Y') }}
                                @if($certificate->expiry_date)
                                    - {{ $certificate->expiry_date->format('d/m/Y') }}
                                @endif
                            </p>
                            @if($certificate->credential_id)
                                <p class="text-sm text-gray-600">
                                    <i class="fas fa-id-badge mr-2"></i>
                                    ID: {{ $certificate->credential_id }}
                                </p>
                            @endif
                        </div>

                        @if($certificate->tools->count() > 0)
                            <div class="mb-4">
                                <div class="flex flex-wrap gap-2">
                                    @foreach($certificate->tools as $tool)
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ $tool->name }}
                                        </span>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <div class="flex items-center justify-between mt-4 pt-4 border-t">
                            <div class="flex space-x-3">
                                <a href="{{ route('certificates.edit', $certificate) }}" class="text-indigo-600 hover:text-indigo-900">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <form action="{{ route('certificates.destroy', $certificate) }}" method="POST" class="inline" onsubmit="return confirm('¿Estás seguro de querer eliminar este certificado?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </form>
                            </div>
                            @if($certificate->credential_url)
                                <a href="{{ $certificate->credential_url }}" target="_blank" class="text-indigo-600 hover:text-indigo-900">
                                    <i class="fas fa-external-link-alt"></i>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-6">
            {{ $certificates->links() }}
        </div>
    @else
        <div class="text-center py-12 bg-white rounded-lg shadow-sm">
            <i class="fas fa-certificate text-gray-400 text-4xl mb-4"></i>
            <h3 class="text-lg font-medium text-gray-900 mb-2">No hay certificados registrados</h3>
            <p class="text-gray-500 mb-6">Comienza añadiendo tu primer certificado</p>
            <a href="{{ route('certificates.create') }}" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700">
                <i class="fas fa-plus mr-2"></i>
                Nuevo Certificado
            </a>
        </div>
    @endif
</div>
@endsection