@extends('layouts.app')
@section('title', $term ? "Resultados para \"{$term}\"" : 'Pesquisa')
@section('meta_description', $term ? "Resultados de pesquisa para \"{$term}\" em " . config('app.name', 'Vitrine') . '.' : 'Pesquise produtos e serviços.')
@section('content')
    <x-app-container x-data="searchPage()" class="py-4">
        <div class="row g-4">
            <div class="col-lg-3 order-2 order-lg-1">
                <x-sidebar-lists :categories="$categories" :entities="$entities" />
            </div>
            <div class="col-lg-9 order-1 order-lg-2">
                <form @submit.prevent class="mb-4 d-flex gap-2 flex-wrap align-items-center">
                    <input x-model="q" type="text" placeholder="Buscar produto ou serviço..."
                        class="form-control flex-grow-1" style="min-width:0;"
                        @input.debounce.300ms="perform()" />
                    <select x-model="type" class="form-select" style="width:10rem;" @change="perform()">
                        <option value="">Todos</option>
                        <option value="product">Produtos</option>
                        <option value="service">Serviços</option>
                    </select>
                    <div class="form-check m-0">
                        <input class="form-check-input" type="checkbox" id="promoSearch" x-model="promo" @change="perform()">
                        <label class="form-check-label small text-muted" for="promoSearch">Promoções</label>
                    </div>
                </form>

                <div class="d-flex align-items-center justify-content-between mb-3 small text-muted" x-show="loaded">
                    <span x-text="countText()"></span>
                </div>

                <template x-if="q === ''">
                    <x-empty icon="🔍" title="Pesquise algo" subtitle="Digite um termo acima para encontrar produtos e serviços." />
                </template>

                <div class="row row-cols-1 row-cols-md-3 g-3" x-show="results.length">
                    <template x-for="item in results" :key="item.id">
                        <div class="col">
                            <a :href="item.url" class="card h-100 product-card overflow-hidden text-decoration-none">
                                <div class="ratio ratio-16x9 overflow-hidden" style="background:#fff7ed;">
                                    <img :src="item.image || placeholder" alt="" class="object-fit-cover w-100 h-100" loading="lazy" />
                                </div>
                                <div class="card-body p-3 d-flex flex-column gap-1">
                                    <h3 class="small fw-medium lh-sm truncate-2 text-body mb-0" x-text="item.name"></h3>
                                    <p class="text-muted text-uppercase mb-0" style="font-size:.75rem;letter-spacing:.05em;" x-text="item.entity.name"></p>
                                    <div class="d-flex align-items-center justify-content-between mt-auto pt-2 small">
                                        <span class="badge rounded-pill text-bg-warning" x-text="item.type === 'product' ? 'Produto' : 'Serviço'"></span>
                                        <span class="fw-bold text-primary" x-text="formatPrice(item.price)"></span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </template>
                </div>

                <template x-if="q !== '' && loaded && results.length === 0">
                    <x-empty icon="😕" title="Sem resultados" subtitle="Nenhum resultado para a sua pesquisa. Tente outros termos." />
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
                                'image' => $p->image_path ? asset($p->image_path) : null,
                                'entity' => ['name' => $p->entity->name, 'slug' => $p->entity->slug],
                                'url' => route('product.show', $p->publicRouteParameters()),
                            ])),
                    loaded: true,
                    placeholder: 'data:image/svg+xml,%3Csvg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 400 225"%3E%3Crect width="400" height="225" fill="%23FFF7ED"/%3E%3C/svg%3E',
                    perform() {
                        if (this.q.trim() === '') {
                            this.results = [];
                            this.loaded = true;
                            return;
                        }
                        const searchUrl = @json(route('search'));
                        fetch(`${searchUrl}?q=${encodeURIComponent(this.q)}&type=${this.type}&promo=${this.promo ? 1 : 0}`, {
                                headers: { 'Accept': 'application/json' }
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
                        return parseFloat(v).toLocaleString('pt-MZ', { minimumFractionDigits: 2 }) + ' MT';
                    }
                }
            }
        </script>
    @endpush
@endsection
