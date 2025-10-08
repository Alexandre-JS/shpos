@extends('layouts.app')
@section('content')
    <x-app-container>
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <div class="lg:col-span-1 order-2 lg:order-1">
                <x-sidebar-lists :categories="$categories" :entities="$entities" />
            </div>
            <div class="lg:col-span-3 order-1 lg:order-2">
                <h1 class="text-2xl font-bold mb-6">{{ $title }}</h1>
                @include('partials.product-grid-paginated', ['paginator' => $products])
            </div>
        </div>
    </x-app-container>
@endsection
