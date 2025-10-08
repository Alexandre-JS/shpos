@extends('layouts.dashboard')
@section('nav.entity', 'bg-gray-100 font-medium')
@section('header', 'Configurações da Entidade')
@section('content')
    <div class="max-w-4xl space-y-6">
        <form action="{{ route('dashboard.entity.settings.update') }}" method="POST" enctype="multipart/form-data"
            class="bg-white border rounded p-6 space-y-6">
            @csrf
            @method('PUT')
            <div class="grid md:grid-cols-2 gap-6">
                <div>
                    <label class="block text-xs font-medium mb-1">Nome *</label>
                    <input name="name" value="{{ old('name', $entity->name) }}" required
                        class="w-full border rounded px-3 py-2 text-sm" />
                    @error('name')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-xs font-medium mb-1">Email</label>
                    <input name="email" value="{{ old('email', $entity->email) }}"
                        class="w-full border rounded px-3 py-2 text-sm" />
                    @error('email')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-xs font-medium mb-1">Telefone</label>
                    <input name="phone" value="{{ old('phone', $entity->phone) }}"
                        class="w-full border rounded px-3 py-2 text-sm" />
                    @error('phone')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-xs font-medium mb-1">WhatsApp (258XXXXXXXXX)</label>
                    <input name="whatsapp" value="{{ old('whatsapp', $entity->whatsapp) }}"
                        class="w-full border rounded px-3 py-2 text-sm" />
                    @error('whatsapp')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-xs font-medium mb-1">Cidade</label>
                    <input name="location_city" value="{{ old('location_city', $entity->location_city) }}"
                        class="w-full border rounded px-3 py-2 text-sm" />
                </div>
                <div>
                    <label class="block text-xs font-medium mb-1">Distrito / Província</label>
                    <input name="location_district" value="{{ old('location_district', $entity->location_district) }}"
                        class="w-full border rounded px-3 py-2 text-sm" />
                </div>
            </div>
            <div>
                <label class="block text-xs font-medium mb-1">Descrição *</label>
                <textarea name="description" rows="6" class="w-full border rounded px-3 py-2 text-sm" required>{{ old('description', $entity->description) }}</textarea>
                @error('description')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="grid md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-xs font-medium mb-1">Instagram URL</label>
                    <input name="instagram_url" value="{{ old('instagram_url', $entity->instagram_url) }}"
                        class="w-full border rounded px-3 py-2 text-sm" />
                    @error('instagram_url')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-xs font-medium mb-1">Facebook URL</label>
                    <input name="facebook_url" value="{{ old('facebook_url', $entity->facebook_url) }}"
                        class="w-full border rounded px-3 py-2 text-sm" />
                    @error('facebook_url')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-xs font-medium mb-1">Website URL</label>
                    <input name="website_url" value="{{ old('website_url', $entity->website_url) }}"
                        class="w-full border rounded px-3 py-2 text-sm" />
                    @error('website_url')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="grid md:grid-cols-3 gap-6">
                <div>
                    <label class="block text-xs font-medium mb-1">Instagram URL</label>
                    <input name="instagram_url" value="{{ old('instagram_url', $entity->instagram_url) }}"
                        class="w-full border rounded px-3 py-2 text-sm" />
                    @error('instagram_url')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-xs font-medium mb-1">Facebook URL</label>
                    <input name="facebook_url" value="{{ old('facebook_url', $entity->facebook_url) }}"
                        class="w-full border rounded px-3 py-2 text-sm" />
                    @error('facebook_url')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="block text-xs font-medium mb-1">Website URL</label>
                    <input name="website_url" value="{{ old('website_url', $entity->website_url) }}"
                        class="w-full border rounded px-3 py-2 text-sm" />
                    @error('website_url')
                        <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="space-y-2">
                <label class="block text-xs font-medium mb-1">Logotipo</label>
                @if ($entity->logo_path)
                    <div
                        class="w-28 aspect-square bg-gray-100 flex items-center justify-center overflow-hidden rounded border">
                        <img src="/{{ $entity->logo_path }}" alt="logo" class="object-cover w-full h-full" />
                    </div>
                @endif
                <input type="file" name="logo" accept="image/jpeg,image/png,image/webp" class="w-full text-sm" />
                <p class="text-[10px] text-gray-500">Formatos: JPG, PNG, WebP até 2MB.</p>
                @error('logo')
                    <p class="text-xs text-red-600 mt-1">{{ $message }}</p>
                @enderror
            </div>
            <div class="flex justify-end gap-3 pt-2">
                <a href="{{ route('dashboard.index') }}" class="px-4 py-2 text-sm border rounded">Voltar</a>
                <button class="px-5 py-2 text-sm bg-blue-600 text-white rounded hover:bg-blue-700">Salvar</button>
            </div>
        </form>
    </div>
@endsection
