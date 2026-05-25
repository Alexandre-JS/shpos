@extends('layouts.admin')
@section('title', 'Editar — ' . $entity->name)
@section('header', 'Editar Empresa')
@section('nav.admin.entities', 'bg-gray-800 text-white')

@section('content')
<div class="max-w-2xl space-y-6">

    <div class="flex items-center gap-3 text-sm text-gray-500">
        <a href="{{ route('admin.entities.index') }}" class="hover:underline">Empresas</a>
        <span>/</span>
        <span class="text-gray-800 font-medium">{{ $entity->name }}</span>
    </div>

    @if($errors->any())
        <div class="bg-red-50 border border-red-200 text-red-700 p-3 rounded text-sm">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.entities.update', $entity) }}"
          class="bg-white rounded border divide-y">
        @csrf @method('PUT')

        {{-- Informação básica --}}
        <div class="p-5 space-y-4">
            <h2 class="font-semibold text-sm text-gray-700 uppercase tracking-wide">Informação</h2>
            <div class="space-y-1">
                <label class="text-xs font-medium text-gray-600">Nome da empresa</label>
                <input type="text" name="name" value="{{ old('name', $entity->name) }}" required
                       class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-gray-400" />
            </div>
            <div class="space-y-1">
                <label class="text-xs font-medium text-gray-600">Descrição</label>
                <textarea name="description" rows="3" required
                          class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-gray-400">{{ old('description', $entity->description) }}</textarea>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div class="space-y-1">
                    <label class="text-xs font-medium text-gray-600">Cidade</label>
                    <input type="text" name="location_city" value="{{ old('location_city', $entity->location_city) }}" required
                           class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-gray-400" />
                </div>
                <div class="space-y-1">
                    <label class="text-xs font-medium text-gray-600">Distrito</label>
                    <input type="text" name="location_district" value="{{ old('location_district', $entity->location_district) }}"
                           class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-gray-400" />
                </div>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div class="space-y-1">
                    <label class="text-xs font-medium text-gray-600">Telefone</label>
                    <input type="text" name="phone" value="{{ old('phone', $entity->phone) }}"
                           class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-gray-400" />
                </div>
                <div class="space-y-1">
                    <label class="text-xs font-medium text-gray-600">WhatsApp</label>
                    <input type="text" name="whatsapp" value="{{ old('whatsapp', $entity->whatsapp) }}"
                           class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-gray-400" />
                </div>
            </div>
            <div class="space-y-1">
                <label class="text-xs font-medium text-gray-600">Email público</label>
                <input type="email" name="email" value="{{ old('email', $entity->email) }}"
                       class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-gray-400" />
            </div>
        </div>

        {{-- Configurações da plataforma --}}
        <div class="p-5 space-y-4">
            <h2 class="font-semibold text-sm text-gray-700 uppercase tracking-wide">Configurações da Plataforma</h2>
            <div class="grid grid-cols-2 gap-3">
                <div class="space-y-1">
                    <label class="text-xs font-medium text-gray-600">Estado de aprovação</label>
                    <select name="status" class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-gray-400">
                        <option value="pending"  {{ old('status', $entity->status) === 'pending'  ? 'selected' : '' }}>Pendente</option>
                        <option value="approved" {{ old('status', $entity->status) === 'approved' ? 'selected' : '' }}>Aprovada</option>
                        <option value="rejected" {{ old('status', $entity->status) === 'rejected' ? 'selected' : '' }}>Rejeitada</option>
                    </select>
                </div>
                <div class="space-y-1">
                    <label class="text-xs font-medium text-gray-600">Plano</label>
                    <select name="plan_type" class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring-1 focus:ring-gray-400">
                        <option value="free"    {{ old('plan_type', $entity->plan_type) === 'free'    ? 'selected' : '' }}>Gratuito</option>
                        <option value="premium" {{ old('plan_type', $entity->plan_type) === 'premium' ? 'selected' : '' }}>Premium</option>
                    </select>
                </div>
            </div>
            <div class="flex gap-6">
                <label class="flex items-center gap-2 text-sm cursor-pointer">
                    <input type="checkbox" name="is_active" value="1" {{ old('is_active', $entity->is_active) ? 'checked' : '' }}
                           class="w-4 h-4 rounded border-gray-300" />
                    Visível na plataforma
                </label>
                <label class="flex items-center gap-2 text-sm cursor-pointer">
                    <input type="checkbox" name="is_featured" value="1" {{ old('is_featured', $entity->is_featured) ? 'checked' : '' }}
                           class="w-4 h-4 rounded border-gray-300" />
                    Em destaque
                </label>
            </div>
        </div>

        <div class="p-5 flex justify-between items-center">
            <a href="{{ route('admin.entities.index') }}" class="text-sm text-gray-500 hover:underline">Cancelar</a>
            <button class="bg-gray-900 text-white px-5 py-2 rounded text-sm hover:bg-gray-700">Guardar alterações</button>
        </div>
    </form>

    {{-- Produtos da entidade --}}
    @if($entity->products->isNotEmpty())
        <div class="bg-white rounded border">
            <div class="px-4 py-3 border-b flex items-center justify-between">
                <h2 class="font-semibold text-sm">Produtos / Serviços (últimos 10)</h2>
                <a href="{{ route('entity.show', $entity->slug) }}" target="_blank"
                   class="text-xs text-blue-600 hover:underline">Ver perfil público</a>
            </div>
            <div class="divide-y">
                @foreach($entity->products as $product)
                    <div class="px-4 py-3 flex items-center justify-between text-sm gap-3">
                        <div class="min-w-0">
                            <p class="font-medium truncate">{{ $product->name }}</p>
                            <p class="text-xs text-gray-400">{{ ucfirst($product->type) }} · {{ $product->category?->name ?? '—' }}</p>
                        </div>
                        <div class="flex items-center gap-3 shrink-0">
                            @if($product->price)
                                <span class="text-xs text-gray-600">{{ number_format($product->price, 2) }} MZN</span>
                            @endif
                            <span class="text-xs {{ $product->is_active ? 'text-green-600' : 'text-gray-400' }}">
                                {{ $product->is_active ? 'Activo' : 'Inactivo' }}
                            </span>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

</div>
@endsection
