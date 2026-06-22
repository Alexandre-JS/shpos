@extends('layouts.app')
@section('title', $entity->name)
@section('meta_description', \Illuminate\Support\Str::limit(strip_tags($entity->description), 160))
@push('meta')
    @if($entity->logo_path)
        <meta property="og:image" content="{{ asset($entity->logo_path) }}" />
    @endif
@endpush
@section('content')
    <x-app-container class="py-4 vstack gap-4">

        <x-breadcrumb :items="[
            ['label' => 'Home', 'url' => route('home')],
            ['label' => 'Lojas', 'url' => route('entities.index')],
            ['label' => $entity->name],
        ]" />

        <header class="vstack gap-4">
            <div class="d-flex align-items-start gap-4">
                @if ($entity->logo_path)
                    <div class="rounded-4 border bg-white d-flex align-items-center justify-content-center overflow-hidden shadow-sm flex-shrink-0" style="width:6rem;height:6rem;">
                        <img src="/{{ $entity->logo_path }}" alt="{{ $entity->name }}" class="object-fit-cover w-100 h-100" />
                    </div>
                @else
                    <div class="rounded-4 border border-warning-subtle d-flex align-items-center justify-content-center text-primary flex-shrink-0 shadow-sm" style="width:6rem;height:6rem;background:#fff7ed;">
                        <i class="bi bi-shop fs-1"></i>
                    </div>
                @endif
                <div class="flex-grow-1 min-w-0">
                    <h1 class="fs-2 fw-bold lh-sm mb-1">{{ $entity->name }}</h1>
                    <p class="small text-muted d-flex align-items-center gap-1 mb-0">
                        <i class="bi bi-geo-alt text-primary"></i>
                        {{ $entity->location_city }}{{ $entity->location_district ? ', ' . $entity->location_district : '' }}
                    </p>
                </div>
            </div>

            @if ($entity->description)
                <p class="text-secondary-emphasis small lh-base mb-0" style="max-width:48rem;">{{ $entity->description }}</p>
            @endif

            <x-contact-buttons :entity="$entity" />

            <div class="pt-1">
                <x-share-buttons :url="url()->current()" :title="$entity->name" />
            </div>
        </header>

        <section>
            <div class="d-flex align-items-center justify-content-between mb-4">
                <h2 class="fs-4 fw-bold mb-0">Produtos / Serviços</h2>
                <div class="rounded-pill bg-primary" style="height:.25rem;width:2rem;"></div>
            </div>
            @include('partials.product-grid', ['items' => $entity->products])
        </section>

    </x-app-container>
@endsection
