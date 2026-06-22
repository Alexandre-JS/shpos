@props([
    'number', // já no formato 258XXXXXXXXX ou null
    'text' => null,
    'label' => 'WhatsApp',
    'size' => 'sm',
    'product' => null,
])
@php
    $n = $number;
    if ($n && !preg_match('/^258\d{9}$/', $n)) {
        // inválido - não renderiza link clicável
        $n = null;
    }
    $defaultMessage = 'Olá, vi ' . ($product ? 'o produto ' . $product : 'o seu perfil') . ' na plataforma';
    $msg = urlencode($text ?: $defaultMessage);
    $sizeCls = $size === 'xs' ? 'btn-sm' : 'btn-' . $size;
@endphp
@if ($n)
    <a target="_blank" rel="noopener" href="https://wa.me/{{ $n }}?text={{ $msg }}"
        class="btn {{ $sizeCls }} btn-success d-inline-flex align-items-center gap-1">
        <i class="bi bi-whatsapp"></i>
        <span>{{ $label }}</span>
    </a>
@else
    <span class="btn {{ $sizeCls }} btn-success disabled opacity-50" title="Número inválido">WhatsApp</span>
@endif
