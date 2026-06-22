@props([
'action' => route('search'),
'name' => 'q',
'placeholder' => 'Buscar produtos ou serviços',
'value' => request('q'),
'categories' => \App\Models\Category::query()->active()->orderBy('name')->select('id', 'name', 'slug')->get(),
])
@php($live = $attributes->get('live'))
<div x-data="searchBarComponent({ live: @json((bool) $live), initial: @json($value), url: @json($action), initialCategory: @json(request('cat')) })" class="position-relative">
    <form x-ref="form" :action="url" method="GET" @submit.prevent="submit()" class="d-flex gap-2">
        <select x-model="category" name="cat" @change="changed" class="form-select form-select-sm rounded-3 shadow-sm" style="width:9rem;">
            <option value="">Todas</option>
            @foreach ($categories as $c)
            <option value="{{ $c->slug }}">{{ $c->name }}</option>
            @endforeach
        </select>
        <div class="position-relative flex-grow-1">
            <input x-model="q" type="text" name="{{ $name }}" placeholder="{{ $placeholder }}"
                @input.debounce.300ms="changed"
                class="form-control rounded-3 shadow-sm ps-5" />
            <span class="position-absolute top-50 start-0 translate-middle-y ps-3 text-muted">
                <i class="bi bi-search"></i>
            </span>
        </div>
    </form>
    <template x-if="live && open && q.trim() !== ''">
        <div class="position-absolute mt-2 w-100 overflow-auto bg-white border rounded-4 shadow-lg" style="z-index:20;max-height:24rem;">
            <div class="px-3 py-2 small text-muted d-flex justify-content-between align-items-center border-bottom">
                <span x-text="countText()"></span>
                <button class="btn btn-link btn-sm p-0 d-inline-flex align-items-center gap-1 fw-medium text-decoration-none" type="button" @click="goFull()">
                    Ver todos <i class="bi bi-arrow-right"></i>
                </button>
            </div>
            <template x-if="loading">
                <div class="p-4 text-center small text-muted">A pesquisar...</div>
            </template>
            <ul class="list-unstyled mb-0">
                <template x-for="item in results" :key="item.id">
                    <li>
                        <a :href="item.url" class="d-flex gap-3 p-3 text-decoration-none text-body">
                            <img :src="item.image || placeholder" class="rounded-3 flex-shrink-0 object-fit-cover bg-light" style="width:3rem;height:3rem;" />
                            <div class="flex-grow-1 min-w-0">
                                <p class="small fw-medium text-truncate mb-0" x-text="item.name"></p>
                                <p class="text-muted text-truncate text-uppercase mb-0" style="font-size:.75rem;letter-spacing:.05em;" x-text="item.entity.name"></p>
                            </div>
                            <div class="small fw-bold text-primary flex-shrink-0" x-text="formatPrice(item.price)"></div>
                        </a>
                    </li>
                </template>
            </ul>
            <template x-if="!loading && results.length===0">
                <div class="p-4 small text-muted text-center">Sem resultados</div>
            </template>
        </div>
    </template>
</div>

@once
@push('scripts')
<script>
    function searchBarComponent({
        live,
        initial,
        url,
        initialCategory
    }) {
        return {
            live,
            url,
            initialCategory,
            q: initial || '',
            results: [],
            open: false,
            loading: false,
            placeholder: 'https://via.placeholder.com/80x80?text=—',
            changed() {
                if (!this.live) return;
                this.fetch();
            },
            submit() {
                if (this.live) {
                    this.fetch();
                } else {
                    this.$refs.form.submit();
                }
            },
            fetch() {
                const term = this.q.trim();
                if (term === '') {
                    this.results = [];
                    this.open = false;
                    return;
                }
                this.loading = true;
                this.open = true;
                const params = new URLSearchParams();
                params.set('q', term);
                if (this.category) params.set('cat', this.category);
                fetch(`${url}?${params.toString()}`, {
                        headers: {
                            'Accept': 'application/json'
                        }
                    })
                    .then(r => r.json())
                    .then(data => {
                        this.results = data.data || [];
                    })
                    .catch(() => {})
                    .finally(() => {
                        this.loading = false;
                    });
            },
            goFull() {
                const params = new URLSearchParams();
                if (this.q) params.set('q', this.q);
                if (this.category) params.set('cat', this.category);
                window.location = `${url}?${params.toString()}`;
            },
            countText() {
                return this.results.length + ' resultado' + (this.results.length === 1 ? '' : 's');
            },
            formatPrice(v) {
                if (v == null) return '';
                return 'MZN ' + parseFloat(v).toFixed(2);
            },
            category: null,
            init() {
                this.category = this.initialCategory || '';
            }
        }
    }
</script>
@endpush
@endonce
