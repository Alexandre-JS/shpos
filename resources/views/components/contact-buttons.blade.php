@props(['entity', 'productName' => null])
<div class="d-flex flex-wrap gap-2 small pt-2">
    @if ($entity->whatsapp)
    <x-whatsapp-button :number="$entity->whatsapp" :product="$productName" size="sm" />
    @endif
    @if ($entity->phone)
    <a class="btn btn-sm btn-outline-primary" href="tel:{{ $entity->phone }}"><i class="bi bi-telephone me-1"></i>Telefone</a>
    @endif
    @if ($entity->email)
    <a class="btn btn-sm btn-outline-secondary" href="mailto:{{ $entity->email }}"><i class="bi bi-envelope me-1"></i>Email</a>
    @endif
    @if ($entity->instagram_url)
    <a class="btn btn-sm btn-outline-danger" target="_blank" href="{{ $entity->instagram_url }}"><i class="bi bi-instagram me-1"></i>Instagram</a>
    @endif
    @if ($entity->facebook_url)
    <a class="btn btn-sm btn-outline-primary" target="_blank" href="{{ $entity->facebook_url }}"><i class="bi bi-facebook me-1"></i>Facebook</a>
    @endif
    @if ($entity->website_url)
    <a class="btn btn-sm btn-outline-dark" target="_blank" href="{{ $entity->website_url }}"><i class="bi bi-globe me-1"></i>Website</a>
    @endif
</div>
