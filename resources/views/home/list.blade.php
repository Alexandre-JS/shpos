@extends('layouts.app')
@section('content')
    <x-app-container>
        <h1 class="text-2xl font-bold mb-6">{{ $title }}</h1>
        @include('partials.product-grid-paginated', ['paginator' => $products])
    </x-app-container>
@endsection
