@extends('layouts.app')

@section('title', $certificate->title)

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="flex items-center justify-between mb-6">
        <h2 class="text-2xl font-semibold text-gray-900">{{ $certificate->title }}</h2>
        <div class="flex space-x-3">
            <a href="{{ route('certificates.edit', $certificate) }}" class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                <i class="fas fa-edit mr-2"></i>
                Editar
            </a>
            <a href="{{ route('certificates.index') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50">
                <i class="fas fa-arrow-left mr-2"></i>
                Volver
            </a>
        </div>
    </div>

    <div class="bg-white shadow overflow-hidden sm:rounded-lg">
        <div class="px-4 py-5 sm:px-6">
            <div class="flex items-center">
                @if($certificate->image)
                    <img src="{{ Storage::url($certificate->image) }}" alt="{{ $certificate->title }}" class="h-24 w-auto object-contain mr-6">
                @endif
                <div>
                    <h3 class="text-lg leading-6 font-medium text-gray-900">Detalles del Certificado</h3>
                    <p class="mt-1 max-w-2xl text-sm text-gray-500">
                        Emitido por {{ $certificate->issuing_organization }}
                    </p>
                </div>
            </div>
        </div>
        <div class="border-t border-gray-200">
            <dl>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Título</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $certificate->title }}</dd>
                </div>
                <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Organización Emisora</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $certificate->issuing_organization }}</dd>
                </div>
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Fecha de Emisión</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $certificate->issue_date->format('d/m/Y') }}</dd>
                </div>
                @if($certificate->expiry_date)
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Fecha de Expiración</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $certificate->expiry_date->format('d/m/Y') }}</dd>
                    </div>
                @endif
                @if($certificate->credential_id)
                    <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">ID de Credencial</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $certificate->credential_id }}</dd>
                    </div>
                @endif
                @if($certificate->credential_url)
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">URL de Verificación</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            <a href="{{ $certificate->credential_url }}" target="_blank" class="text-indigo-600 hover:text-indigo-900">
                                Verificar Credencial <i class="fas fa-external-link-alt ml-1"></i>
                            </a>
                        </dd>
                    </div>
                @endif
                <div class="bg-gray-50 px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                    <dt class="text-sm font-medium text-gray-500">Descripción</dt>
                    <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">{{ $certificate->description }}</dd>
                </div>
                @if($certificate->tools->count() > 0)
                    <div class="bg-white px-4 py-5 sm:grid sm:grid-cols-3 sm:gap-4 sm:px-6">
                        <dt class="text-sm font-medium text-gray-500">Herramientas/Tecnologías</dt>
                        <dd class="mt-1 text-sm text-gray-900 sm:mt-0 sm:col-span-2">
                            <div class="flex flex-wrap gap-2">
                                @foreach($certificate->tools as $tool)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $tool->name }}
                                    </span>
                                @endforeach
                            </div>
                        </dd>
                    </div>
                @endif
            </dl>
        </div>
    </div>
</div>
@endsection