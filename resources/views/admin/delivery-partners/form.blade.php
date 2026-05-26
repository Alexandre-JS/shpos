@extends('layouts.admin')
@section('header', $partner->exists ? 'Editar Parceiro' : 'Novo Parceiro de Entrega')
@section('nav.delivery', 'bg-indigo-900 text-white font-medium')
@section('content')
<div class="max-w-2xl">
    <form method="POST"
          action="{{ $partner->exists ? route('admin.delivery-partners.update', $partner) : route('admin.delivery-partners.store') }}"
          class="bg-white border rounded p-6 space-y-5">
        @csrf
        @if ($partner->exists) @method('PUT') @endif

        <div class="grid sm:grid-cols-2 gap-5">
            <div class="sm:col-span-2">
                <label class="block text-xs font-medium mb-1">Nome *</label>
                <input name="name" value="{{ old('name', $partner->name) }}" required
                       class="input" />
                @error('name')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="sm:col-span-2">
                <label class="block text-xs font-medium mb-1">Descrição</label>
                <textarea name="description" rows="3" class="input resize-none">{{ old('description', $partner->description) }}</textarea>
                @error('description')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-xs font-medium mb-1">Telefone</label>
                <input name="phone" value="{{ old('phone', $partner->phone) }}" class="input" placeholder="+258 84 000 0000" />
                @error('phone')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-xs font-medium mb-1">Email</label>
                <input name="email" type="email" value="{{ old('email', $partner->email) }}" class="input" />
                @error('email')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-xs font-medium mb-1">Website</label>
                <input name="website" type="url" value="{{ old('website', $partner->website) }}" class="input" placeholder="https://" />
                @error('website')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
            </div>

            <div>
                <label class="block text-xs font-medium mb-1">Posição (ordem)</label>
                <input name="position" type="number" min="0" value="{{ old('position', $partner->position ?? 0) }}" class="input" />
                @error('position')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
            </div>

            <div class="sm:col-span-2">
                <label class="block text-xs font-medium mb-1">Áreas de cobertura</label>
                <input name="coverage_areas" value="{{ old('coverage_areas', $partner->coverage_areas) }}" class="input"
                       placeholder="Ex: Maputo, Matola, Beira" />
                <p class="text-[10px] text-gray-400 mt-1">Cidades ou províncias separadas por vírgula.</p>
                @error('coverage_areas')<p class="text-xs text-red-600 mt-1">{{ $message }}</p>@enderror
            </div>
        </div>

        <div class="flex items-center gap-2">
            <input type="checkbox" name="is_active" id="is_active" value="1"
                   @checked(old('is_active', $partner->exists ? $partner->is_active : true)) />
            <label for="is_active" class="text-sm">Activo (visível publicamente)</label>
        </div>

        <div class="flex justify-between pt-2">
            <a href="{{ route('admin.delivery-partners.index') }}" class="btn btn-outline btn-sm">Cancelar</a>
            <button type="submit" class="btn btn-primary btn-sm">Salvar</button>
        </div>
    </form>
</div>
@endsection
