@props([
'action' => route('search'),
'name' => 'q',
'placeholder' => 'Buscar produtos ou serviços',
'value' => request('q'),
'categories' => \App\Models\Category::query()->active()->orderBy('name')->select('id', 'name', 'slug')->get(),
])
@php($live = $attributes->get('live'))
<div x-data="searchBarComponent({ live: @json((bool) $live), initial: @json($value), url: @json($action), initialCategory: @json(request('cat')) })" class="relative group">
    <form x-ref="form" :action="url" method="GET" @submit.prevent="submit()" class="flex gap-2">
        <div class="relative">
            <select x-model="category" name="cat" @change="changed" class="select w-36 rounded-xl border-gray-200">
                <option value="">Todas</option>
                @foreach ($categories as $c)
                <option value="{{ $c->slug }}">{{ $c->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="relative flex-1">
            <input x-model="q" type="text" name="{{ $name }}" placeholder="{{ $placeholder }}"
                @input.debounce.300ms="changed"
                class="w-full border border-gray-200 rounded-xl pl-10 pr-4 py-2.5 focus:ring-2 focus:ring-primary/30 outline-none" />
            <span
                class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 group-focus-within:text-primary">🔍</span>
        </div>
    </form>
    <template x-if="live && open && q.trim() !== ''">
        <div class="absolute z-20 mt-2 w-full bg-white border rounded shadow max-h-96 overflow-auto">
            <div class="p-2 text-xs text-gray-500 flex justify-between items-center">
                <span x-text="countText()"></span>
                <button class="link link-primary" type="button" @click="goFull()">Ver todos</button>
            </div>
            <template x-if="loading">
                <div class="p-4 text-center text-sm">Carregando...</div>
            </template>
            <ul>
                <template x-for="item in results" :key="item.id">
                    <li>
                        <a :href="item.url" class="flex gap-3 p-2 hover:bg-gray-100">
                            <img :src="item.image || placeholder" class="w-12 h-12 object-cover rounded bg-gray-100" />
                            <div class="flex-1 min-w-0">
                                <p class="text-sm font-medium truncate" x-text="item.name"></p>
                                <p class="text-xs text-gray-500 truncate" x-text="item.entity.name"></p>
                            </div>
                            <div class="text-xs font-semibold" x-text="formatPrice(item.price)"></div>
                        </a>
                    </li>
                </template>
            </ul>
            <template x-if="!loading && results.length===0">
                <div class="p-3 text-sm text-gray-500">Sem resultados</div>
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
        url
    }) {
        return {
            live,
            url,
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