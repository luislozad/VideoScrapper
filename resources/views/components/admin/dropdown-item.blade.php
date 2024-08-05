@props(['url'])

<a class="dropdown-item" href="{{ $url }}">
    {{ $slot }}
</a>