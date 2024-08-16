@php
use App\Models\Ads;

$homeAds = null;

try {
  $dataHomeAds = Ads::where('type', 'home-ads')->first();
  if ($dataHomeAds) {
    $homeAds = json_decode($dataHomeAds->data, true);
  }
} catch (\Throwable $th) {
  Log::info($th);
}
@endphp

<section class="hero shape-1 pt-4">
    <div class="container">
      <div class="d-flex justify-content-center">
        <div class="col-8 flex-shrink-0 container-mv">
          <h1 class="text-center text-title">{{ __('Download HD videos') }}</h1>
          <p class="lead mt-4 font-weight-light text-subtitle">{{ __('Download videos from your favorite social media sites.') }}</p>
          <!-- Subscription form-->
          {{-- <form action="#" class="subscription-form mt-5">
            <div class="form-group">
              <label>Email</label>
              <input type="email" name="email" placeholder="your@email.com" class="form-control">
              <button type="submit" class="btn btn-primary">Start tracking</button>
            </div>
          </form> --}}
          @if ($homeAds)
            @if ($homeAds['top']['checked'])
            {!! $homeAds['top']['code'] !!}
            @endif
          @endif
          @livewire('frontend.video-download')
          @if ($homeAds)
            @if ($homeAds['bottom']['checked'])
            {!! $homeAds['bottom']['code'] !!}
            @endif
          @endif          
          <!-- Platforms-->
          <div class="platforms d-none d-lg-block"><span class="platforms-title">{{ __('Supported') }}</span>
            <ul class="platforms-list list-inline">
              <li class="list-inline-item"><img src="{{ asset('front/img/brand-instagram.svg') }}" alt="" class="platform-image img-fluid"></li>
              <li class="list-inline-item"><img src="{{ asset('front/img/brand-facebook.svg') }}" alt="" class="platform-image img-fluid"></li>
              <li class="list-inline-item"><img src="{{ asset('front/img/brand-tiktok.svg') }}" alt="" class="platform-image img-fluid"></li>
            </ul>
          </div>
        </div>
        {{-- <div class="col-lg-6 d-none d-lg-block">
          <div class="device-wrapper mx-auto">
            <div data-device="iPhone7" data-orientation="portrait" data-color="black" class="device">
              <div class="screen"><img src="{{ asset('front/img/screen.jpg?v=1') }}" alt="..." class="img-fluid"></div>
            </div>
          </div>
        </div> --}}
      </div>
    </div>
  </section>