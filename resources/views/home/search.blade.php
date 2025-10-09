@extends('layouts.app')
@section('content')
    <x-app-container x-data="searchPage()">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">
            <div class="lg:col-span-1 order-2 lg:order-1">
                <x-sidebar-lists :categories="$categories" :entities="$entities" />
            </div>
            <div class="lg:col-span-3 order-1 lg:order-2">
                <form @submit.prevent class="mb-4 flex gap-2 flex-wrap items-center">
                    <input x-model="q" type="text" placeholder="Buscar..." class="input input-bordered flex-1"
                        @input.debounce.300ms="perform()" />
                    <select x-model="type" class="select select-bordered w-40" @change="perform()">
                        <option value="">Todos</option>
                        <option value="product">Produtos</option>
                        <option value="service">Serviços</option>
                    </select>
                    <label class="inline-flex items-center gap-2 text-sm">
                        <input type="checkbox" x-model="promo" @change="perform()"> <span>Promoções</span>
                    </label>
                </form>
                <div class="flex items-center justify-between mb-2 text-sm text-gray-500" x-show="loaded">
                    <span x-text="countText()"></span>
                </div>
                <template x-if="q === ''">
                    <p class="text-sm text-gray-500">Digite um termo para pesquisar.</p>
                </template>
                <div id="results" class="grid md:grid-cols-3 gap-4" x-show="results.length">
                    <template x-for="item in results" :key="item.id">
                        <a :href="item.url" class="card shadow-sm hover:shadow-md transition border border-gray-200">
                            <figure class="aspect-video overflow-hidden bg-gray-100">
                                <img :src="item.image || placeholder" alt="" class="object-cover w-full h-full"
                                    loading="lazy" />
                            </figure>
                            <div class="card-body p-4">
                                <h3 class="text-sm font-medium" x-text="item.name"></h3>
                                <p class="text-xs text-gray-500" x-text="item.entity.name"></p>
                                <div class="flex items-center justify-between mt-2 text-xs">
                                    <span class="badge badge-outline"
                                        x-text="item.type === 'product' ? 'Produto' : 'Serviço'"></span>
                                    <span class="font-semibold" x-text="formatPrice(item.price)"></span>
                                </div>
                            </div>
                        </a>
                    </template>
                </div>
                <template x-if="q !== '' && loaded && results.length === 0">
                    <p class="text-sm text-gray-500">Nenhum resultado encontrado.</p>
                </template>
            </div>
        </div>
    </x-app-container>
    @push('scripts')
        <script>
            function searchPage() {
                return {
                    q: @json($term),
                    type: @json($type ?? ''),
                    promo: @json($promo ?? false),
                    results: @json(
                        $results->map(fn($p) => [
                                'id' => $p->id,
                                'name' => $p->name,
                                'slug' => $p->slug,
                                'type' => $p->type,
                                'price' => $p->price,
                                'image' => $p->image_path ? asset('storage/' . $p->image_path) : null,
                                'entity' => ['name' => $p->entity->name, 'slug' => $p->entity->slug],
                                'url' => route('product.show', $p->slug),
                            ])),
                    loaded: true,
                    placeholder: 'https://via.placeholder.com/400x225?text=Sem+Imagem',
                    perform() {
                        if (this.q.trim() === '') {
                            this.results = [];
                            this.loaded = true;
                            return;
                        }
                        const searchUrl = @json(route('search'));
                        fetch(`${searchUrl}?q=${encodeURIComponent(this.q)}&type=${this.type}&promo=${this.promo ? 1 : 0}`, {
                                headers: {
                                    'Accept': 'application/json'
                                }
                            })
                            .then(r => r.json())
                            .then(data => {
                                this.results = data.data;
                                this.loaded = true;
                            })
                            .catch(() => {});
                    },
                    countText() {
                        return this.results.length + ' resultado' + (this.results.length === 1 ? '' : 's');
                    },
                    formatPrice(v) {
                        if (v == null) return '';
                        return 'MZN ' + parseFloat(v).toFixed(2);
                    }
                }
            }
        </script>
    @endpush
@endsection
