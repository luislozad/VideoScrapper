@props(['url', 'title'])

<li class="nav-item">
    <a class="nav-link" href="{{ $url }}" >
        <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/checkbox -->
            {{ $icon }}
        </span>
        <span class="nav-link-title">
        {{ $title }}
        </span>
    </a>
</li>