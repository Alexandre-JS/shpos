<div class="vstack gap-4">
    @include('partials.product-grid', ['items' => $paginator])
    <div>
        {{ $paginator->links() }}
    </div>
</div>
