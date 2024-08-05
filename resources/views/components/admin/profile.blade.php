@php
    $username = Auth::user()->name;
@endphp

<div class="userprofile nav-item dropdown" {{ $attributes }}>
    <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
      <span class="avatar avatar-sm" style="background: url({{ Avatar::create($username)->setShape('square')->toBase64() }}); background-size: cover;"></span>
      <div class="d-none d-xl-block ps-2">
        <div>{{ $username }}</div>
        <div class="mt-1 small text-muted">{{ __('Administrator') }}</div>
      </div>
    </a>
    <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
        {{ $slot }}
    </div>
  </div>