@props(['categories' => collect(), 'entities' => collect()])

<aside class="vstack gap-4 small">
    <div>
        <h3 class="fw-bolder text-uppercase text-primary mb-3" style="font-size:.625rem;letter-spacing:.2em;">Lojas</h3>
        <ul class="list-group shadow-sm">
            @forelse($entities as $e)
                <li class="list-group-item p-0">
                    <a href="{{ route('entity.show', $e->slug) }}"
                        class="d-flex align-items-center justify-content-between px-3 py-2 text-decoration-none link-body-emphasis list-soft-link">
                        <span class="text-truncate">{{ $e->name }}</span>
                        <span class="badge rounded-pill text-bg-light ms-2">{{ $e->items_count }}</span>
                    </a>
                </li>
            @empty
                <li class="list-group-item text-muted small">Sem lojas</li>
            @endforelse
        </ul>
        @if ($entities instanceof \Illuminate\Support\Collection && $entities->count() === 30)
            <p class="mt-2 text-muted" style="font-size:.625rem;">
                Top 30. <a href="{{ route('entities.index') }}" class="link-primary text-decoration-none fw-medium">Ver todas »</a>
            </p>
        @else
            <p class="mt-2 text-muted" style="font-size:.625rem;">Ordenado por itens.</p>
        @endif
    </div>
</aside>
