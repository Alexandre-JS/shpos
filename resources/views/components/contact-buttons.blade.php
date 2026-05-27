@props(['entity', 'productName' => null])
<div class="flex flex-wrap gap-2 text-sm pt-2">
    @if ($entity->whatsapp)
    <x-whatsapp-button :number="$entity->whatsapp" :product="$productName" size="xs" />
    @endif
    @if ($entity->phone)
    <a class="btn btn-xs bg-blue-50 text-blue-700 hover:bg-blue-100 border-none"
        href="tel:{{ $entity->phone }}">Telefone</a>
    @endif
    @if ($entity->email)
    <a class="btn btn-xs bg-orange-50 text-orange-700 hover:bg-orange-100 border-none px-3 font-bold"
        href="mailto:{{ $entity->email }}">Email</a>
    @endif
    @if ($entity->instagram_url)
    <a class="btn btn-xs bg-pink-50 text-pink-700 hover:bg-pink-100 border-none" target="_blank"
        href="{{ $entity->instagram_url }}">Instagram</a>
    @endif
    @if ($entity->facebook_url)
    <a class="btn btn-xs bg-blue-100 text-blue-800 hover:bg-blue-200 border-none" target="_blank"
        href="{{ $entity->facebook_url }}">Facebook</a>
    @endif
    @if ($entity->website_url)
    <a class="btn btn-xs bg-gray-200 text-gray-700 hover:bg-gray-300 border-none" target="_blank"
        href="{{ $entity->website_url }}">Website</a>
    @endif
</div>