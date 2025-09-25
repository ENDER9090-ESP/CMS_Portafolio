@extends('layouts.app')

@section('title', 'Organizar Portfolio')

@section('content')
<div class="container mx-auto px-4 py-6">
    <div class="mb-6">
        <h2 class="text-2xl font-semibold text-gray-900">Organizar Portfolio</h2>
        <p class="mt-1 text-sm text-gray-600">Arrastra y suelta los elementos para organizarlos en tu portfolio</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Lista Ordenada del Portfolio -->
        <div class="bg-white shadow rounded-lg p-6">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Portfolio Actual</h3>
            <div id="portfolio-list" class="space-y-4">
                @forelse($portfolioItems as $item)
                    <div class="bg-white border rounded-lg shadow-sm p-4 cursor-move" 
                        data-id="{{ $item->id }}" 
                        data-type="{{ strtolower(class_basename($item->item_type)) }}" 
                        data-item-id="{{ $item->item_id }}">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <i class="fas fa-grip-vertical text-gray-400 mr-3"></i>
                                <div>
                                    @if($item->item_type === 'App\Models\Project')
                                        <i class="fas fa-project-diagram text-blue-500 mr-2"></i>
                                        <span class="text-xs font-medium text-blue-700 bg-blue-100 px-2 py-0.5 rounded">Proyecto</span>
                                    @elseif($item->item_type === 'App\Models\Certificate')
                                        <i class="fas fa-certificate text-green-500 mr-2"></i>
                                        <span class="text-xs font-medium text-green-700 bg-green-100 px-2 py-0.5 rounded">Certificado</span>
                                    @else
                                        <i class="fas fa-graduation-cap text-purple-500 mr-2"></i>
                                        <span class="text-xs font-medium text-purple-700 bg-purple-100 px-2 py-0.5 rounded">Carrera</span>
                                    @endif
                                </div>
                            </div>
                            <button onclick="removeItem(this)" class="text-red-600 hover:text-red-900">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                        <h4 class="text-sm font-medium text-gray-900 mt-2">{{ $item->item->title }}</h4>
                    </div>
                @empty
                    <div id="empty-portfolio" class="text-center py-8 bg-gray-50 rounded-lg border-2 border-dashed">
                        <p class="text-gray-500">No hay elementos en el portfolio</p>
                        <p class="text-sm text-gray-400">Arrastra elementos desde las listas de la derecha</p>
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Elementos Disponibles -->
        <div class="space-y-6">
            <!-- Proyectos -->
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Proyectos Disponibles</h3>
                <div id="projects-list" class="space-y-4">
                    @forelse($projects as $project)
                        <div class="bg-white border rounded-lg shadow-sm p-4 cursor-move"
                            data-type="project" 
                            data-item-id="{{ $project->id }}">
                            <div class="flex items-center">
                                <i class="fas fa-grip-vertical text-gray-400 mr-3"></i>
                                <i class="fas fa-project-diagram text-blue-500 mr-2"></i>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900">{{ $project->title }}</h4>
                                    <p class="text-xs text-gray-500">{{ Str::limit($project->description, 100) }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-500 py-4">No hay proyectos disponibles</p>
                    @endforelse
                </div>
            </div>

            <!-- Certificados -->
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Certificados Disponibles</h3>
                <div id="certificates-list" class="space-y-4">
                    @forelse($certificates as $certificate)
                        <div class="bg-white border rounded-lg shadow-sm p-4 cursor-move"
                            data-type="certificate" 
                            data-item-id="{{ $certificate->id }}">
                            <div class="flex items-center">
                                <i class="fas fa-grip-vertical text-gray-400 mr-3"></i>
                                <i class="fas fa-certificate text-green-500 mr-2"></i>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900">{{ $certificate->title }}</h4>
                                    <p class="text-xs text-gray-500">{{ $certificate->issuing_organization }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-500 py-4">No hay certificados disponibles</p>
                    @endforelse
                </div>
            </div>

            <!-- Carreras -->
            <div class="bg-white shadow rounded-lg p-6">
                <h3 class="text-lg font-medium text-gray-900 mb-4">Carreras Disponibles</h3>
                <div id="careers-list" class="space-y-4">
                    @forelse($careers as $career)
                        <div class="bg-white border rounded-lg shadow-sm p-4 cursor-move"
                            data-type="career" 
                            data-item-id="{{ $career->id }}">
                            <div class="flex items-center">
                                <i class="fas fa-grip-vertical text-gray-400 mr-3"></i>
                                <i class="fas fa-graduation-cap text-purple-500 mr-2"></i>
                                <div>
                                    <h4 class="text-sm font-medium text-gray-900">{{ $career->title }}</h4>
                                    <p class="text-xs text-gray-500">{{ $career->institution }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-500 py-4">No hay carreras disponibles</p>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <div class="mt-6 flex justify-end">
        <button onclick="saveOrder()" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-indigo-600 hover:bg-indigo-700">
            <i class="fas fa-save mr-2"></i>
            Guardar Cambios
        </button>
    </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.14.0/Sortable.min.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Hacer que la lista del portfolio sea ordenable
    new Sortable(document.getElementById('portfolio-list'), {
        animation: 150,
        ghostClass: 'bg-gray-100'
    });

    // Hacer que las listas de elementos disponibles sean arrastrables
    ['projects-list', 'certificates-list', 'careers-list'].forEach(listId => {
        new Sortable(document.getElementById(listId), {
            animation: 150,
            group: {
                name: 'shared',
                pull: 'clone',
                put: false
            },
            sort: false
        });
    });

    // Hacer que la lista del portfolio acepte elementos
    new Sortable(document.getElementById('portfolio-list'), {
        animation: 150,
        group: {
            name: 'shared',
            pull: true,
            put: true
        }
    });
});

function removeItem(button) {
    button.closest('.cursor-move').remove();
    checkEmptyState();
}

function checkEmptyState() {
    const portfolioList = document.getElementById('portfolio-list');
    const emptyMessage = document.getElementById('empty-portfolio');
    
    if (portfolioList.children.length === 0) {
        if (!emptyMessage) {
            portfolioList.innerHTML = `
                <div id="empty-portfolio" class="text-center py-8 bg-gray-50 rounded-lg border-2 border-dashed">
                    <p class="text-gray-500">No hay elementos en el portfolio</p>
                    <p class="text-sm text-gray-400">Arrastra elementos desde las listas de la derecha</p>
                </div>
            `;
        }
    } else if (emptyMessage) {
        emptyMessage.remove();
    }
}

function saveOrder() {
    const items = Array.from(document.getElementById('portfolio-list').children)
        .filter(item => item.dataset.type)
        .map((item, index) => ({
            id: item.dataset.id || null,
            type: item.dataset.type,
            item_id: item.dataset.itemId,
        }));

    fetch('{{ route('portfolio.reorder') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}'
        },
        body: JSON.stringify({ items })
    })
    .then(response => response.json())
    .then(data => {
        // Mostrar mensaje de éxito
        alert('Portfolio actualizado correctamente');
        // Recargar la página para actualizar los IDs
        window.location.reload();
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error al guardar los cambios');
    });
}
</script>
@endpush

@endsection