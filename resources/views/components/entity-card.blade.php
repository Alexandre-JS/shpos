@props(['entity'])
<a href="{{ route('entity.show', $entity->slug) }}"
    class="card h-100 text-decoration-none p-3 entity-card">
    <div class="d-flex align-items-start justify-content-between gap-2">
        <h3 class="fw-semibold small lh-sm truncate-2 mb-0 text-body">{{ $entity->name }}</h3>
        @if ($entity->is_featured)
            <span class="badge rounded-pill text-bg-warning flex-shrink-0" style="font-size:.625rem;">Destaque</span>
        @endif
    </div>
    @if ($entity->description)
        <p class="small text-muted truncate-2 mt-2 mb-0">{{ $entity->description }}</p>
    @endif
    <div class="mt-auto pt-3 d-flex align-items-center gap-3 text-muted" style="font-size:.6875rem;">
        @if ($entity->location_city)
            <span class="d-inline-flex align-items-center gap-1">
                <i class="bi bi-geo-alt text-primary"></i>{{ $entity->location_city }}
            </span>
        @endif
        <span class="ms-auto fw-semibold text-secondary-emphasis">{{ $entity->products()->count() }} itens</span>
    </div>
</a>
