@props(['title', 'image', 'checked' => false])

<div class="card">
    <div class="card-body">
        <h3 class="card-title">{{ $title }}</h3>
    </div>
    <!-- Photo -->
    <div class="img-responsive img-responsive-21x9 card-img-bottom" style="background-image: url({{ asset($image) }})"></div>

    <div class="card-footer">
        <ul class="nav nav-pills card-header-pills">
            <li class="nav-item flex items-center">
                <label class="form-check form-switch" style="margin-bottom: 0px;">
                    <input class="form-check-input" type="checkbox"  {{ $checked === true ? 'checked' : '' }} {{ $attributes }}>
                </label>
            </li>
            <li class="nav-item ms-auto">
                {{ $slot }}
            </li>
          </ul>
    </div>            
</div>