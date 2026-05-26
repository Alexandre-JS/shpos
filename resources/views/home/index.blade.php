@extends('layouts.app')
@section('title', config('app.name'))
@section('meta_description', 'Descubra produtos e serviços de empresas moçambicanas. Encontre o que procura e contacte directamente o vendedor.')
@section('content')

{{-- ══════════════════════════════════════════════
     HERO BANNER
══════════════════════════════════════════════ --}}
<div class="w-full" style="background:#F0F4FF">
    <div class="max-w-7xl mx-auto px-4 py-6 grid md:grid-cols-3 gap-4 items-stretch">

        {{-- Banner principal (2/3) --}}
        <div class="md:col-span-2 rounded-2xl overflow-hidden relative flex items-center min-h-[240px]"
             style="background:linear-gradient(135deg,#1E1B4B 0%,#312E81 60%,#3730A3 100%)">
            {{-- Decoração botânica (SVG inline, canto direito) --}}
            <svg class="absolute right-0 bottom-0 opacity-10 w-72 h-72" viewBox="0 0 200 200" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="150" cy="150" r="120" stroke="white" stroke-width="1"/>
                <circle cx="150" cy="150" r="80" stroke="white" stroke-width="1"/>
                <circle cx="150" cy="150" r="40" stroke="white" stroke-width="1"/>
                <line x1="30" y1="150" x2="200" y2="150" stroke="white" stroke-width="0.5"/>
                <line x1="150" y1="30" x2="150" y2="200" stroke="white" stroke-width="0.5"/>
            </svg>
            <div class="relative z-10 px-8 py-8 space-y-4 max-w-md">
                <span class="inline-flex items-center gap-1.5 text-xs font-medium px-3 py-1 rounded-full"
                      style="background:rgba(255,255,255,0.1);color:#A5B4FC">
                    🇲🇿 Plataforma Moçambicana
                </span>
                <h1 class="text-2xl sm:text-3xl font-bold text-white leading-tight">
                    Encontre tudo numa<br>só plataforma
                </h1>
                <p class="text-indigo-200 text-sm leading-relaxed">
                    Produtos e serviços de empresas moçambicanas.<br>
                    Compre, encomende e receba onde estiver.
                </p>
                <div class="flex items-center gap-4 pt-1">
                    <div class="text-center">
                        <div class="text-xl font-bold text-white">{{ $totalProducts }}</div>
                        <div class="text-[10px] text-indigo-300 uppercase tracking-wide">Produtos</div>
                    </div>
                    <div class="w-px h-8 bg-indigo-700"></div>
                    <div class="text-center">
                        <div class="text-xl font-bold text-white">{{ $totalEntities }}</div>
                        <div class="text-[10px] text-indigo-300 uppercase tracking-wide">Lojas</div>
                    </div>
                    <div class="w-px h-8 bg-indigo-700"></div>
                    <div class="text-center">
                        <div class="text-xl font-bold text-white">{{ $categories->count() }}</div>
                        <div class="text-[10px] text-indigo-300 uppercase tracking-wide">Categorias</div>
                    </div>
                </div>
                <div class="flex gap-3 pt-2">
                    <a href="{{ route('products') }}"
                       class="px-5 py-2.5 rounded-lg text-sm font-semibold text-white transition-all hover:opacity-90"
                       style="background:var(--color-accent)">Ver Produtos</a>
                    <a href="{{ route('register.show') }}"
                       class="px-5 py-2.5 rounded-lg text-sm font-semibold border border-indigo-400 text-indigo-200 hover:bg-white/10 transition-all">
                        Registar Loja
                    </a>
                </div>
            </div>
        </div>

        {{-- Card de promoção (1/3) --}}
        <div class="rounded-2xl flex flex-col justify-between p-6 min-h-[200px]"
             style="background:var(--color-accent)">
            <div class="space-y-2">
                <div class="inline-flex items-center gap-1 text-xs font-semibold bg-white/20 text-white px-2.5 py-1 rounded-full">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                    Promoções Activas
                </div>
                @if ($discounted->isNotEmpty())
                    <p class="text-3xl font-extrabold text-white leading-tight">
                        {{ $discounted->count() }}<span class="text-lg font-medium"> ofertas</span>
                    </p>
                    <p class="text-amber-100 text-sm">Descontos exclusivos em produtos seleccionados</p>
                @else
                    <p class="text-2xl font-extrabold text-white leading-tight">Registe<br>a sua loja</p>
                    <p class="text-amber-100 text-sm">Mostre os seus produtos a clientes em todo o país</p>
                @endif
            </div>
            <a href="{{ $discounted->isNotEmpty() ? route('products', ['promo' => 1]) : route('register.show') }}"
               class="inline-block mt-4 bg-white text-amber-600 font-semibold text-sm px-5 py-2.5 rounded-lg hover:bg-amber-50 transition-all w-fit">
                {{ $discounted->isNotEmpty() ? 'Ver Promoções →' : 'Começar grátis →' }}
            </a>
        </div>
    </div>
</div>

{{-- ══════════════════════════════════════════════
     BROWSE BY CATEGORY
══════════════════════════════════════════════ --}}
@if ($categories->isNotEmpty())
<section class="max-w-7xl mx-auto px-4 mt-10">
    <div class="flex items-center justify-between mb-5">
        <h2 class="text-xl font-bold text-gray-900">Comprar por Categoria</h2>
        <a href="{{ route('products') }}" class="text-sm text-amber-600 hover:text-amber-700 font-medium">Ver todas →</a>
    </div>

    @php
        $catBg     = ['#EEF2FF','#FFFBEB','#F0FDF4','#FFF1F2','#F5F3FF','#FFF7ED','#ECFDF5','#F0F9FF'];
        $catColor  = ['#4F46E5','#D97706','#16A34A','#E11D48','#7C3AED','#EA580C','#059669','#0284C7'];
        $catIcons  = [
            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>',
            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>',
            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A2 2 0 013 12V7a2 2 0 012-2z"/>',
            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 3H5a2 2 0 00-2 2v4m6-6h10a2 2 0 012 2v4M9 3v18m0 0h10a2 2 0 002-2V9M9 21H5a2 2 0 01-2-2V9m0 0h18"/>',
            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/>',
            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"/>',
            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>',
            '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>',
        ];
    @endphp

    <div class="grid grid-cols-4 sm:grid-cols-4 md:grid-cols-8 gap-3">
        @foreach ($categories->take(8) as $i => $cat)
            @php
                $idx = $i % 8;
                $bg  = $catBg[$idx];
                $cl  = $catColor[$idx];
                $ico = $catIcons[$idx];
            @endphp
            <a href="{{ route('category.show', $cat->slug) }}"
               class="flex flex-col items-center gap-2 p-4 rounded-xl border border-transparent hover:border-gray-200 hover:shadow-sm transition-all text-center group">
                <div class="w-14 h-14 rounded-xl flex items-center justify-center group-hover:scale-105 transition-transform"
                     style="background:{{ $bg }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="{{ $cl }}">
                        {!! $ico !!}
                    </svg>
                </div>
                <span class="text-xs font-medium text-gray-700 leading-tight line-clamp-2">{{ $cat->name }}</span>
                @if ($cat->items_count > 0)
                    <span class="text-[10px] text-gray-400">{{ $cat->items_count }}</span>
                @endif
            </a>
        @endforeach
    </div>
</section>
@endif

{{-- ══════════════════════════════════════════════
     EM PROMOÇÃO
══════════════════════════════════════════════ --}}
@if ($discounted->isNotEmpty())
<section class="max-w-7xl mx-auto px-4 mt-12">
    <div class="flex items-center justify-between mb-5">
        <div class="flex items-center gap-3">
            <h2 class="text-xl font-bold text-gray-900">Em Promoção</h2>
            <span class="inline-flex items-center gap-1 text-xs font-medium px-2 py-0.5 rounded-full text-amber-700" style="background:#FFFBEB">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                </svg>
                Descontos activos
            </span>
        </div>
        <a href="{{ route('products', ['promo' => 1]) }}" class="text-sm text-amber-600 hover:text-amber-700 font-medium">Ver todos →</a>
    </div>
    @include('partials.product-grid', ['items' => $discounted->take(10)])
</section>
@endif

{{-- ══════════════════════════════════════════════
     RECENTEMENTE ADICIONADOS
══════════════════════════════════════════════ --}}
@if ($recent->isNotEmpty())
<section class="max-w-7xl mx-auto px-4 mt-12">
    <div class="flex items-center justify-between mb-5">
        <h2 class="text-xl font-bold text-gray-900">Recentemente Adicionados</h2>
        <a href="{{ route('products') }}" class="text-sm text-amber-600 hover:text-amber-700 font-medium">Ver todos →</a>
    </div>
    @include('partials.product-grid', ['items' => $recent])
</section>
@endif

{{-- ══════════════════════════════════════════════
     MAIS PROCURADOS
══════════════════════════════════════════════ --}}
@if ($mostViewed->isNotEmpty())
<section class="max-w-7xl mx-auto px-4 mt-12">
    <div class="flex items-center justify-between mb-5">
        <h2 class="text-xl font-bold text-gray-900">Mais Procurados</h2>
    </div>
    @include('partials.product-grid', ['items' => $mostViewed])
</section>
@endif

{{-- ══════════════════════════════════════════════
     LOJAS EM DESTAQUE
══════════════════════════════════════════════ --}}
@if ($entities->isNotEmpty())
<section class="max-w-7xl mx-auto px-4 mt-12">
    <div class="flex items-center justify-between mb-5">
        <h2 class="text-xl font-bold text-gray-900">Lojas</h2>
        <a href="{{ route('entities.index') }}" class="text-sm text-amber-600 hover:text-amber-700 font-medium">Ver todas →</a>
    </div>
    <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 lg:grid-cols-6 gap-3">
        @foreach ($entities->take(6) as $entity)
            <x-entity-card :entity="$entity" />
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
