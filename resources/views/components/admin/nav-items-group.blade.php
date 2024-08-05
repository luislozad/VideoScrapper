@props(['title'])

<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle" data-bs-toggle="dropdown" data-bs-auto-close="false" role="button" aria-expanded="false">
      <span class="nav-link-icon d-md-none d-lg-inline-block"><!-- Download SVG icon from http://tabler-icons.io/i/layout-2 -->
        {{ $icon }}
      </span>
      <span class="nav-link-title">
        {{ $title }}
      </span>
    </a>
    <div class="dropdown-menu">
      <div class="dropdown-menu-columns">
        {{ $slot }}
      </div>
    </div>
  </li>