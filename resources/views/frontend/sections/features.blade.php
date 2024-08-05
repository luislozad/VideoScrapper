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

<section class="features pb-big shape-2">         
    <div class="container">
      <div class="section-header text-center"><span class="section-header-title">{{ __('Features') }}</span>
        <h2 class="h1">{{ __('Easy and fast') }}</h2>
        <div class="row">
          <div class="col-lg-8 mx-auto">
            <p class="lead">{{ __('Is the best tool to download video, images and audio from your favorite social media networks, completely free.', ['app' => $appName]) }}</p>
          </div>
        </div>
      </div>
      <div class="row mt-5 text-center">
        <div class="col-lg-4">
          <div class="features-item mb-5 mb-lg-0">
            <div class="gradient-icon gradient-1"><i class="icon ion-ios-play"></i></div>
            <h3 class="h5">{{ __('Unlimited') }}</h3>
            <p>{{ __('Save as many videos as you need, without limits.') }}</p>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="features-item mb-5 mb-lg-0">
            <div class="gradient-icon gradient-2"><i class="icon ion-ios-cog"></i></div>
            <h3 class="h5">{{ __('No watermark!') }}</h3>
            <p>{{ __('Download videos from TikTok, Instagram or Facebook without watermark.') }}</p>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="features-item mb-5 mb-lg-0">
            <div class="gradient-icon gradient-3"><i class="icon ion-ios-notifications"></i></div>
            <h3 class="h5">{{ __('MP4 and MP3') }}</h3>
            <p>{{ __('Save videos in HD quality.') }}</p>
          </div>
        </div>
      </div>
    </div>
  </section>