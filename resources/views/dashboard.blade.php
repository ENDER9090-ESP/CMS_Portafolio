@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <!-- Resumen de Proyectos -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800">
                <i class="fas fa-project-diagram text-blue-500 mr-2"></i> Proyectos
            </h3>
            <a href="{{ route('projects.create') }}" class="text-blue-500 hover:text-blue-700">
                <i class="fas fa-plus"></i>
            </a>
        </div>
        <div class="text-3xl font-bold text-gray-700 mb-2">
            {{ $projectsCount ?? 0 }}
        </div>
        <p class="text-sm text-gray-500">Proyectos activos</p>
    </div>

    <!-- Resumen de Certificados -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800">
                <i class="fas fa-certificate text-green-500 mr-2"></i> Certificados
            </h3>
            <a href="{{ route('certificates.create') }}" class="text-green-500 hover:text-green-700">
                <i class="fas fa-plus"></i>
            </a>
        </div>
        <div class="text-3xl font-bold text-gray-700 mb-2">
            {{ $certificatesCount ?? 0 }}
        </div>
        <p class="text-sm text-gray-500">Certificaciones obtenidas</p>
    </div>

    <!-- Resumen de Herramientas -->
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="text-lg font-semibold text-gray-800">
                <i class="fas fa-tools text-purple-500 mr-2"></i> Herramientas
            </h3>
            <a href="{{ route('tools.create') }}" class="text-purple-500 hover:text-purple-700">
                <i class="fas fa-plus"></i>
            </a>
        </div>
        <div class="text-3xl font-bold text-gray-700 mb-2">
            {{ $toolsCount ?? 0 }}
        </div>
        <p class="text-sm text-gray-500">Tecnologías dominadas</p>
    </div>
</div>

<!-- Actividad Reciente -->
<div class="mt-8">
    <h3 class="text-lg font-semibold text-gray-800 mb-4">Actividad Reciente</h3>
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="divide-y divide-gray-200">
            @forelse($recentActivities ?? [] as $activity)
            <div class="p-4 hover:bg-gray-50">
                <div class="flex items-center">
                    <span class="flex-shrink-0 h-10 w-10 rounded-full bg-gray-200 flex items-center justify-center">
                        <i class="fas fa-bell text-gray-500"></i>
                    </span>
                    <div class="ml-4">
                        <p class="text-sm font-medium text-gray-900">{{ $activity->description }}</p>
                        <p class="text-sm text-gray-500">{{ $activity->created_at->diffForHumans() }}</p>
                    </div>
                </div>
            </div>
            @empty
            <div class="p-4 text-center text-gray-500">
                No hay actividad reciente
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection