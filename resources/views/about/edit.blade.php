@extends('layouts.app')

@section('title', 'Editar Perfil')

@section('content')
<div class="bg-white rounded-lg shadow-sm p-6">
    <form action="{{ route('about.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')

        <div class="space-y-6">
            <!-- Imagen de Perfil -->
            <div>
                <label class="block text-sm font-medium text-gray-700">
                    Imagen de Perfil
                </label>
                <div class="mt-1 flex items-center space-x-4">
                    <div class="w-32 h-32 rounded-full overflow-hidden bg-gray-100">
                        @if($about->profile_image ?? false)
                            <img src="{{ Storage::url($about->profile_image) }}" alt="Perfil" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center">
                                <i class="fas fa-user text-4xl text-gray-400"></i>
                            </div>
                        @endif
                    </div>
                    <input type="file" name="profile_image" class="hidden" id="profile_image">
                    <button type="button" onclick="document.getElementById('profile_image').click()" 
                            class="bg-gray-200 py-2 px-4 rounded-md text-sm text-gray-700 hover:bg-gray-300 transition duration-200">
                        Cambiar Imagen
                    </button>
                </div>
            </div>

            <!-- Información Personal -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nombre</label>
                    <input type="text" name="name" value="{{ $about->name ?? old('name') }}" 
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Título Profesional</label>
                    <input type="text" name="title" value="{{ $about->title ?? old('title') }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700">Biografía</label>
                    <textarea name="biography" rows="4" 
                              class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ $about->biography ?? old('biography') }}</textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Email</label>
                    <input type="email" name="email" value="{{ $about->email ?? old('email') }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Teléfono</label>
                    <input type="tel" name="phone" value="{{ $about->phone ?? old('phone') }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700">Ubicación</label>
                    <input type="text" name="location" value="{{ $about->location ?? old('location') }}"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                </div>
            </div>

            <!-- Redes Sociales -->
            <div>
                <h3 class="text-lg font-medium text-gray-700 mb-4">Redes Sociales</h3>
                <div class="space-y-4" id="social-links">
                    @foreach($about->social_links ?? [] as $platform => $url)
                    <div class="flex items-center space-x-4">
                        <select name="social_platforms[]" class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="github" {{ $platform == 'github' ? 'selected' : '' }}>GitHub</option>
                            <option value="linkedin" {{ $platform == 'linkedin' ? 'selected' : '' }}>LinkedIn</option>
                            <option value="twitter" {{ $platform == 'twitter' ? 'selected' : '' }}>Twitter</option>
                            <option value="instagram" {{ $platform == 'instagram' ? 'selected' : '' }}>Instagram</option>
                        </select>
                        <input type="url" name="social_urls[]" value="{{ $url }}" 
                               class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                               placeholder="https://">
                        <button type="button" onclick="this.parentElement.remove()" 
                                class="text-red-500 hover:text-red-700">
                            <i class="fas fa-trash"></i>
                        </button>
                    </div>
                    @endforeach
                </div>
                <button type="button" onclick="addSocialLink()" 
                        class="mt-4 text-blue-500 hover:text-blue-700">
                    <i class="fas fa-plus mr-2"></i> Agregar Red Social
                </button>
            </div>

            <!-- Botones de Acción -->
            <div class="flex justify-end space-x-4">
                <button type="reset" class="py-2 px-4 border border-gray-300 rounded-md text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Cancelar
                </button>
                <button type="submit" class="py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Guardar Cambios
                </button>
            </div>
        </div>
    </form>
</div>

@push('scripts')
<script>
function addSocialLink() {
    const container = document.getElementById('social-links');
    const newLink = `
        <div class="flex items-center space-x-4">
            <select name="social_platforms[]" class="rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500">
                <option value="github">GitHub</option>
                <option value="linkedin">LinkedIn</option>
                <option value="twitter">Twitter</option>
                <option value="instagram">Instagram</option>
            </select>
            <input type="url" name="social_urls[]" 
                   class="flex-1 rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500"
                   placeholder="https://">
            <button type="button" onclick="this.parentElement.remove()" 
                    class="text-red-500 hover:text-red-700">
                <i class="fas fa-trash"></i>
            </button>
        </div>
    `;
    container.insertAdjacentHTML('beforeend', newLink);
}
</script>
@endpush
@endsection