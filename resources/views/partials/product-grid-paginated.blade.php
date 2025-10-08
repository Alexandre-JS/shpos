<div class="space-y-6">
    @include('partials.product-grid', ['items' => $paginator])
    <div>
        {{ $paginator->links() }}
    </div>
</div>
