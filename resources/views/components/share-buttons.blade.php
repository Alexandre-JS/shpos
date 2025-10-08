@props([
    'url',
    'title' => null,
    'size' => 'sm', // sm | md
])
@php
    $encodedUrl = urlencode($url);
    $encodedTitle = urlencode($title ?? $url);
    $btnSize = $size === 'md' ? 'px-3 py-2 text-sm' : 'px-2 py-1 text-xs';
@endphp
<div class="flex items-center gap-2" x-data="{ copied: false, copy(u) { navigator.clipboard.writeText(u).then(() => { this.copied = true;
            setTimeout(() => this.copied = false, 1500); }); } }">
    <a href="https://www.facebook.com/sharer/sharer.php?u={{ $encodedUrl }}" target="_blank" rel="noopener"
        class="btn btn-outline {{ $btnSize }}" title="Partilhar no Facebook">
        <span class="hidden md:inline">Facebook</span>
        <span class="md:hidden">Fb</span>
    </a>
    <a href="https://api.whatsapp.com/send?text={{ $encodedTitle }}%20{{ $encodedUrl }}" target="_blank" rel="noopener"
        class="btn btn-success {{ $btnSize }}" title="Partilhar no WhatsApp">
        WhatsApp
    </a>
    <button type="button" @click="copy('{{ $url }}')" class="btn btn-outline {{ $btnSize }}"
        :class="copied ? 'btn-success' : ''" title="Copiar link">
        <span x-show="!copied">Copiar</span>
        <span x-show="copied">Copiado!</span>
    </button>
</div>
