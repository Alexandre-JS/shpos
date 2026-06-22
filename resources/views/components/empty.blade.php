@props([
    'icon' => '🗂️',
    'title' => 'Nada encontrado',
    'subtitle' => null,
    'action' => null,
])

<div class="d-flex flex-column align-items-center justify-content-center text-center py-5 px-4 border border-dashed rounded bg-white bg-opacity-75">
    <div class="display-5 mb-3 user-select-none">{{ $icon }}</div>
    <h3 class="fw-medium fs-6 mb-0">{{ $title }}</h3>
    @if ($subtitle)
        <p class="mt-1 small text-muted mb-0" style="max-width:28rem;">{{ $subtitle }}</p>
    @endif
    @if ($action)
        <div class="mt-3">{{ $action }}</div>
    @endif
</div>
