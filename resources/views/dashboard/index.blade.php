@extends('layouts.app')

@section('title', 'Dashboard')

@section('content')
    <div class="max-w-7xl mx-auto">
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                    <!-- Estadísticas -->
                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-blue-500 bg-opacity-10">
                                <i class="fas fa-project-diagram text-blue-500 text-2xl"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-gray-500 text-sm">Proyectos</h3>
                                <p class="text-2xl font-semibold">{{ $stats['projects_count'] }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-green-500 bg-opacity-10">
                                <i class="fas fa-certificate text-green-500 text-2xl"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-gray-500 text-sm">Certificados</h3>
                                <p class="text-2xl font-semibold">{{ $stats['certificates_count'] }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-purple-500 bg-opacity-10">
                                <i class="fas fa-tools text-purple-500 text-2xl"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-gray-500 text-sm">Herramientas</h3>
                                <p class="text-2xl font-semibold">{{ $stats['tools_count'] }}</p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white rounded-lg shadow p-6">
                        <div class="flex items-center">
                            <div class="p-3 rounded-full bg-yellow-500 bg-opacity-10">
                                <i class="fas fa-graduation-cap text-yellow-500 text-2xl"></i>
                            </div>
                            <div class="ml-4">
                                <h3 class="text-gray-500 text-sm">Carreras</h3>
                                <p class="text-2xl font-semibold">{{ $stats['careers_count'] }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                    <!-- Proyectos Recientes -->
                    <div class="bg-white rounded-lg shadow">
                        <div class="p-6 border-b">
                            <h2 class="text-xl font-semibold">Proyectos Recientes</h2>
                        </div>
                        <div class="p-6">
                            @if($recent_projects->count() > 0)
                                <div class="space-y-4">
                                    @foreach($recent_projects as $project)
                                        <div class="flex items-center">
                                            @if($project->image)
                                                <img src="{{ Storage::url($project->image) }}" alt="{{ $project->title }}" class="w-12 h-12 rounded object-cover">
                                            @else
                                                <div class="w-12 h-12 rounded bg-gray-200 flex items-center justify-center">
                                                    <i class="fas fa-project-diagram text-gray-400"></i>
                                                </div>
                                            @endif
                                            <div class="ml-4">
                                                <h4 class="font-semibold">{{ $project->title }}</h4>
                                                <p class="text-sm text-gray-500">
                                                    {{ Str::limit($project->description, 50) }}
                                                </p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="mt-4 text-right">
                                    <a href="{{ route('projects.index') }}" class="text-blue-500 hover:text-blue-600">
                                        Ver todos los proyectos →
                                    </a>
                                </div>
                            @else
                                <p class="text-gray-500">No hay proyectos creados aún.</p>
                            @endif
                        </div>
                    </div>

                    <!-- Certificados Recientes -->
                    <div class="bg-white rounded-lg shadow">
                        <div class="p-6 border-b">
                            <h2 class="text-xl font-semibold">Certificados Recientes</h2>
                        </div>
                        <div class="p-6">
                            @if($recent_certificates->count() > 0)
                                <div class="space-y-4">
                                    @foreach($recent_certificates as $certificate)
                                        <div class="flex items-center">
                                            @if($certificate->image)
                                                <img src="{{ Storage::url($certificate->image) }}" alt="{{ $certificate->title }}" class="w-12 h-12 rounded object-cover">
                                            @else
                                                <div class="w-12 h-12 rounded bg-gray-200 flex items-center justify-center">
                                                    <i class="fas fa-certificate text-gray-400"></i>
                                                </div>
                                            @endif
                                            <div class="ml-4">
                                                <h4 class="font-semibold">{{ $certificate->title }}</h4>
                                                <p class="text-sm text-gray-500">
                                                    {{ $certificate->issuing_organization }}
                                                </p>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="mt-4 text-right">
                                    <a href="{{ route('certificates.index') }}" class="text-blue-500 hover:text-blue-600">
                                        Ver todos los certificados →
                                    </a>
                                </div>
                            @else
                                <p class="text-gray-500">No hay certificados creados aún.</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
    </div>
@endsection