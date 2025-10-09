@extends('layouts.app')
@section('content')
    <x-app-container>
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <div class="lg:col-span-1 order-2 lg:order-1">
                <x-sidebar-lists :categories="$categories" :entities="$entities" />
            </div>
            <div class="lg:col-span-3 order-1 lg:order-2">
                <h1 class="text-2xl font-bold mb-6">{{ $title }}</h1>
                <form method="GET" class="mb-4 flex items-center gap-4 text-sm">
                    @foreach (request()->except('promo', 'page') as $k => $v)
                        <input type="hidden" name="{{ $k }}" value="{{ $v }}">
                    @endforeach
                    <label class="inline-flex items-center gap-2">
                        <input type="checkbox" name="promo" value="1" @checked(request('promo'))
                            onchange="this.form.submit()">
                        <span>Em promoção</span>
                    </label>
                    @if (request('promo'))
                        <a href="{{ request()->fullUrlWithQuery(['promo' => null, 'page' => null]) }}"
                            class="text-xs text-gray-500 hover:text-gray-700">Limpar</a>
                    @endif
                </form>
                @include('partials.product-grid-paginated', ['paginator' => $products])
            </div>
        </div>
    </x-app-container>
@endsection
