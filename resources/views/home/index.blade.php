@extends('layouts.app')
@section('title', config('app.name'))
@section('meta_description', 'Descubra produtos e serviços de empresas moçambicanas. Encontre o que procura e contacte directamente o vendedor.')
@section('content')

{{-- ══════════════════════════════════════════════
     HERO — VITRINE DIGITAL
══════════════════════════════════════════════ --}}
<section class="max-w-7xl mx-auto px-4 py-6">
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-5 h-auto lg:h-[350px]">

        {{-- Hero Principal --}}
        <div class="lg:col-span-9 rounded-2xl overflow-hidden relative group shadow-lg">
            <div class="absolute inset-0 bg-gradient-to-br from-orange-600 to-orange-400">
                <img src="https://images.unsplash.com/photo-1441986300917-64674bd600d8?auto=format&fit=crop&w=1200&q=80"
                    class="w-full h-full object-cover mix-blend-overlay opacity-40" alt="Vitrine Digital Moçambique">
            </div>
            <div class="relative z-10 h-full flex flex-col justify-center px-12 space-y-4">
                <span class="inline-flex text-[10px] font-black uppercase tracking-[0.2em] bg-white text-orange-600 px-3 py-1 rounded-full w-fit">
                    Vitrine Digital de Moçambique
                </span>
                <h2 class="text-4xl lg:text-5xl font-black text-white leading-tight">
                    Encontre qualquer<br>produto em <span class="text-orange-100">Moçambique</span>
                </h2>
                <p class="text-white/80 text-sm max-w-lg">Descubra lojas locais de Maputo a Nampula e contacte directamente pelo WhatsApp.</p>
                <div class="flex gap-4 pt-2">
                    <a href="{{ route('products') }}" class="bg-white text-orange-600 px-8 py-3 rounded-xl text-sm font-bold w-fit shadow-lg hover:bg-orange-50 transition-all">
                        Explorar Produtos
                    </a>
                    <a href="{{ route('register.show') }}" class="border-2 border-white text-white px-8 py-3 rounded-xl text-sm font-bold w-fit hover:bg-white hover:text-orange-600 transition-all">
                        Criar Minha Loja
                    </a>
                </div>
            </div>
        </div>

        {{-- Sidebar Cards --}}
        <div class="lg:col-span-3 flex flex-col gap-4">
            {{-- Destaque --}}
            <div class="flex-1 rounded-2xl p-5 relative overflow-hidden group shadow-md border border-orange-200" style="background:#FFF7ED">
                <div class="relative z-10 space-y-2">
                    <p class="text-[10px] font-bold text-orange-600 uppercase tracking-widest">Destaque</p>
                    <h3 class="font-bold leading-tight text-gray-900">Produtos Locais</h3>
                    <p class="text-xs text-gray-500">Qualidade e Tradição Moçambicana</p>
                    <a href="{{ route('products') }}" class="inline-block mt-2 text-xs font-bold text-orange-600 border-b border-orange-500 pb-0.5 hover:text-orange-700">Ver Destaques</a>
                </div>
                <div class="absolute right-[-10px] bottom-[-10px] opacity-10">
                    <svg viewBox="0 0 24 24" class="w-32 h-32 fill-current text-orange-400">
                        <path d="M12 2L1 21h22L12 2z" />
                    </svg>
                </div>
            </div>
            {{-- CTA Vendedores --}}
            <div class="flex-1 bg-orange-500 rounded-2xl p-5 flex flex-col justify-center shadow-md text-white">
                <h3 class="font-bold text-sm leading-tight">Queres vender aqui?</h3>
                <p class="text-xs mt-1 mb-3 opacity-90">Cria a tua montra digital hoje mesmo.</p>
                <a href="{{ route('register.show') }}" class="bg-white text-orange-600 px-4 py-2 rounded-lg text-[10px] font-black uppercase w-fit hover:bg-orange-50 transition-colors">
                    Criar Minha Loja
                </a>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════
     PROPOSTA DE VALOR — COMO FUNCIONA
══════════════════════════════════════════════ --}}
<section style="background:#FFF7ED">
    <div class="max-w-7xl mx-auto px-4 py-12">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-center">
            {{-- Passo 1 --}}
            <div class="flex flex-col items-center gap-3">
                <div class="w-16 h-16 rounded-2xl bg-white flex items-center justify-center shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </div>
                <h3 class="text-sm font-black text-gray-900 uppercase tracking-wide">Descubra</h3>
                <p class="text-xs text-gray-500 max-w-[200px]">Pesquise produtos e serviços de todo o país</p>
            </div>
            {{-- Passo 2 --}}
            <div class="flex flex-col items-center gap-3">
                <div class="w-16 h-16 rounded-2xl bg-white flex items-center justify-center shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
                <h3 class="text-sm font-black text-gray-900 uppercase tracking-wide">Encontre o Produto</h3>
                <p class="text-xs text-gray-500 max-w-[200px]">Veja fotos, preços e detalhes do que precisa</p>
            </div>
            {{-- Passo 3 --}}
            <div class="flex flex-col items-center gap-3">
                <div class="w-16 h-16 rounded-2xl bg-white flex items-center justify-center shadow-sm">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8 text-orange-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                </div>
                <h3 class="text-sm font-black text-gray-900 uppercase tracking-wide">Contacte Directamente</h3>
                <p class="text-xs text-gray-500 max-w-[200px]">Fale com o vendedor pelo WhatsApp ou telefone</p>
            </div>
        </div>
    </div>
</section>

{{-- ══════════════════════════════════════════════
     PRODUTOS EM DESTAQUE
══════════════════════════════════════════════ --}}
<section class="max-w-7xl mx-auto px-4 py-14">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h2 class="text-2xl font-bold text-gray-900">Produtos em Destaque</h2>
            <div class="h-1 w-12 bg-orange-600 mt-2 rounded-full"></div>
        </div>
        <a href="{{ route('products') }}" class="text-sm text-orange-600 hover:text-orange-700 font-medium">Ver todos os produtos →</a>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-5">
        @foreach ($recent->take(8) as $product)
        <div class="bg-white rounded-xl border border-orange-100 overflow-hidden hover:shadow-md transition-shadow">
            <div class="h-48 bg-orange-50 relative overflow-hidden">
                @php
                $primary = method_exists($product, 'primaryImage') ? $product->primaryImage() : null;
                $imgPath = $primary?->path ?? $product->image_path ?? null;
                $imgDisplay = null;
                if ($imgPath) {
                $clean = ltrim($imgPath, '/');
                $small = preg_replace('/(\.[a-zA-Z0-9]+)$/', '_sm$1', $clean);
                $imgDisplay = file_exists(public_path($small)) ? $small : $clean;
                }
                @endphp
                @if ($imgDisplay)
                <img src="/{{ $imgDisplay }}" alt="{{ $product->name }}" loading="lazy"
                    class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                @else
                <div class="w-full h-full flex flex-col items-center justify-center">
                    <svg class="w-12 h-12 text-orange-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                    <span class="text-orange-300 text-xs mt-2">Sem foto</span>
                </div>
                @endif
            </div>

            <div class="p-3">
                @if ($product->entity)
                <p class="text-xs text-gray-400 mb-1">{{ $product->entity->name }}</p>
                @endif

                <h3 class="text-sm font-semibold text-gray-800 line-clamp-2 mb-2 min-h-[2.5rem]">
                    {{ $product->name }}
                </h3>

                @if ($product->price)
                <p class="text-orange-600 font-bold text-sm mb-3">
                    {{ number_format($product->price, 2, ',', '.') }} MT
                </p>
                @else
                <p class="text-gray-400 text-xs italic mb-3">Preço sob consulta</p>
                @endif

                <a href="{{ route('product.show', $product->slug) }}"
                    class="block w-full text-center bg-orange-500 hover:bg-orange-600
                          text-white text-sm font-medium py-2 rounded-lg transition-colors">
                    Contactar Vendedor
                </a>
            </div>
        </div>
        @endforeach
    </div>
</section>

{{-- ══════════════════════════════════════════════
     LOJAS PARCEIRAS
══════════════════════════════════════════════ --}}
@if ($entities->isNotEmpty())
<section class="max-w-7xl mx-auto px-4 mt-4 mb-12">
    <div class="flex items-center justify-between mb-5">
        <h2 class="text-lg font-bold text-gray-900">Lojas Parceiras</h2>
        <a href="{{ route('entities.index') }}" class="text-sm text-orange-600 hover:text-orange-700 font-medium">Ver todas as lojas →</a>
    </div>
    <div class="flex items-center gap-6 flex-wrap">
        @foreach ($entities->take(6) as $entity)
        <a href="{{ route('entity.show', $entity->slug) }}" class="group flex flex-col items-center gap-2" title="{{ $entity->name }}">
            @if ($entity->logo_path && file_exists(public_path(ltrim($entity->logo_path, '/'))))
            <div class="w-16 h-16 rounded-full overflow-hidden border-2 border-orange-100 group-hover:border-orange-400 transition-colors shadow-sm">
                <img src="/{{ ltrim($entity->logo_path, '/') }}" alt="{{ $entity->name }}"
                    class="w-full h-full object-cover">
            </div>
            @else
            <div class="w-16 h-16 rounded-full bg-orange-50 border-2 border-orange-100 group-hover:border-orange-400 flex items-center justify-center transition-colors shadow-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-orange-300 group-hover:text-orange-500 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                </svg>
            </div>
            @endif
            <span class="text-[10px] text-gray-500 font-medium max-w-[70px] truncate text-center group-hover:text-orange-600 transition-colors">{{ $entity->name }}</span>
        </a>
        @endforeach
    </div>
</section>
@endif

{{-- ══════════════════════════════════════════════
     TODOS OS PRODUTOS
══════════════════════════════════════════════ --}}
<section class="max-w-7xl mx-auto px-4 mt-12 mb-8">
    <div class="flex items-center justify-between mb-5">
        <h2 class="text-xl font-bold text-gray-900">Todos os Produtos</h2>
    </div>
    @include('partials.product-grid-paginated', ['paginator' => $products])
</section>

@endsection