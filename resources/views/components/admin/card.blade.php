@props(['title'])

<div class="col-md-6 col-lg-3">
    <div class="card">
      <div class="card-stamp">
        <div class="card-stamp-icon bg-yellow">
          <!-- Download SVG icon from http://tabler-icons.io/i/bell -->
          {{ $icon }}
        </div>
      </div>
      <div class="card-body">
        <h3 class="card-title">{{ $title }}</h3>
        {{ $slot }}
      </div>
    </div>
</div>