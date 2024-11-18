@props([
    'url',
    'color' => 'primary',
    'align' => 'center',
])
<a href="{{ $url }}" style="margin: 10px 0 20px; display: inline-block;" class="button button-{{ $color }}" target="_blank" rel="noopener">{{ $slot }}</a>
