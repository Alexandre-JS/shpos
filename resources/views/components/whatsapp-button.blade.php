@props([
    'number', // já no formato 258XXXXXXXXX ou null
    'text' => null,
    'label' => 'WhatsApp',
    'size' => 'xs',
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
@endphp
@if ($n)
    <a target="_blank" rel="noopener" href="https://wa.me/{{ $n }}?text={{ $msg }}"
        class="btn btn-{{ $size }} btn-success inline-flex items-center gap-1">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="currentColor">
            <path
                d="M12.04 2c-5.52 0-10 4.48-10 10 0 1.77.46 3.42 1.27 4.85L2 22l5.33-1.38A9.96 9.96 0 0 0 12.04 22c5.52 0 10-4.48 10-10s-4.49-10-10-10Zm5.63 14.55c-.24.67-1.39 1.29-1.92 1.33-.53.05-1.02.24-3.45-.72-2.89-1.14-4.75-4.11-4.9-4.3-.14-.19-1.17-1.55-1.17-2.95 0-1.4.74-2.08 1-2.37.26-.29.57-.36.76-.36.19 0 .38 0 .55.01.18.01.42-.07.66.5.24.57.82 1.97.89 2.11.07.14.12.31.02.5-.1.19-.15.31-.29.48-.14.17-.3.38-.43.51-.14.14-.28.29-.12.57.17.29.75 1.24 1.6 2.01 1.1.98 2.03 1.29 2.32 1.44.29.14.46.12.63-.07.17-.19.72-.84.91-1.13.19-.29.38-.24.63-.14.24.1 1.55.73 1.82.86.26.14.43.19.49.29.06.1.06.67-.18 1.34Z" />
        </svg>
        <span>{{ $label }}</span>
    </a>
@else
    <span class="btn btn-{{ $size }} btn-disabled opacity-60" title="Número inválido">WhatsApp</span>
@endif
