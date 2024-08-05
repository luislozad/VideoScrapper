@php
    $appName = config('app.name', 'Laravel');

    try {
      $page = App\Models\Page::first();
      if ($page) {
        $appName = $page->appName;
      }
    } catch (\Throwable $th) {
      Log::info($th);
    }
@endphp

<section class="testimonials bg-black">
  <div class="container">
    <div class="row">
      <div class="col-lg-6 section-padding">
        <div class="section-header pr-3"><span class="section-header-title text-white">{{ $appName }}</span>
          <h2 class="h1 text-white">{{ __('All in one place') }}</h2>
          <p class="lead text-white mt-4 mb-4">{{ __('Is one of the most popular social media video downloading services.', ['app' => $appName]) }}</p><a href="#" class="btn btn-primary">{{ __('Video Downloader') }}</a>
        </div>
      </div>
      <div class="col-lg-6 d-none d-lg-block">
        <div class="row feeds" style="width: 100%;">
          <div style="width: 100%;">
            <div class="showcase-image-holder" style="width: 100%;" >
              <img src="{{ asset('front/img/download.png') }}" alt="..." class="showcase-image d-none d-lg-block" style="z-index: 999; border-radius: 3rem; top: 1rem; right: -72%;">
            </div>            
          </div>
        </div>
      </div>
    </div>
  </div>
</section>