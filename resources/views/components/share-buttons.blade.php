@props([
    'url',
    'title' => null,
    'size' => 'sm', // sm | md
])
@php
    $encodedUrl = urlencode($url);
    $encodedTitle = urlencode($title ?? $url);
    $btnSize = $size === 'md' ? '' : 'btn-sm';
@endphp
<div class="d-flex align-items-center gap-2" x-data="{ copied: false, copy(u) { navigator.clipboard.writeText(u).then(() => { this.copied = true;
            setTimeout(() => this.copied = false, 1500); }); } }">
    <a href="https://www.facebook.com/sharer/sharer.php?u={{ $encodedUrl }}" target="_blank" rel="noopener"
        class="btn btn-outline-primary {{ $btnSize }}" title="Partilhar no Facebook">
        <span class="d-none d-md-inline">Facebook</span>
        <span class="d-md-none">Fb</span>
    </a>
    <a href="https://api.whatsapp.com/send?text={{ $encodedTitle }}%20{{ $encodedUrl }}" target="_blank" rel="noopener"
        class="btn btn-success {{ $btnSize }}" title="Partilhar no WhatsApp">
        WhatsApp
    </a>
    <button type="button" @click="copy('{{ $url }}')" class="btn btn-outline-secondary {{ $btnSize }}"
        :class="copied ? 'btn-success text-white' : ''" title="Copiar link">
        <span x-show="!copied">Copiar</span>
        <span x-show="copied">Copiado!</span>
    </button>
</div>
