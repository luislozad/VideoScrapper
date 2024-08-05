@php
    use App\Models\SocialMedia;

    $social = [];
    $icons = [
      'twitter' => 'ion-logo-twitter',
      'facebook' => 'ion-logo-facebook',
      'youtube' => 'ion-logo-youtube',
      'instagram' => 'ion-logo-instagram',
      'tiktok' => 'ion-logo-tiktok',
    ];
    try {
      $socialSQL = SocialMedia::first();
      // Debugbar::info($socialSQL);
      if ($socialSQL) {
        $data = json_decode($socialSQL->data, true);
        foreach ($icons as $key => $value) {
          $url = $data[$key];
          if (!empty($url)) {
            $social[$key] = [
              'icon' => $value,
              'url' => $url,
            ];
          }
        }
      }
    } catch (\Throwable $th) {
      Log::info($th);
    }
@endphp

<footer class="footer">
    <div class="container text-center">
      <!-- Copyrights-->
      <div class="copyrights">
        <!-- Social menu-->
        <ul class="social list-inline-item">
          @foreach ($social as $item)
            <li class="list-inline-item"><a href="{{ $item['url'] }}" target="_blank" class="social-link"><i class="icon {{ $item['icon'] }}"></i></a></li>
          @endforeach
        </ul>
        <p class="copyrights-text mb-0">Copyright &copy; {{ now()->year }} {{ __('All rights reserved') }}</p>
      </div>
    </div>
</footer>