@php
    $appName = config('app.name', 'Laravel');
    $favicon = asset('front/img/favicon.png');
    $data = [
      'footer' => [
        'code' => '',
        'checked' => false,
      ],
      'header' => [
        'code' => '',
        'checked' => false,
      ]
    ];

    try {
      $page = App\Models\Page::first();
      if ($page) {
        $appName = $page->appName;
        $favicon = $page->icon ? asset("storage/$page->icon") : $favicon;
      }
    } catch (\Throwable $th) {
      Log::info($th);
    }

    try {
      $ad = App\Models\Ads::where('type', 'scripts')->first();
      $data = json_decode($ad->data, true);
    } catch (\Throwable $th) {
      Log::info($th);
    }

@endphp

<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ $appName }} - {{ __('Website title') }}</title>
    <meta name="description" content="{{ __('Website description') }}">
    <meta name="keywords" content="{{ __('Website keywords') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="all,follow">
    
    <link rel="alternate" href="/?lang=es" hreflang="es" />
    <link rel="alternate" href="/?lang=en" hreflang="en" />
    <link rel="alternate" href="/?lang=fr" hreflang="fr" />
    <link rel="alternate" href="/?lang=ar" hreflang="ar" />
    <link rel="alternate" href="/?lang=pt" hreflang="pt" />
    <link rel="alternate" href="/?lang=de" hreflang="de" />
    <link rel="alternate" href="/?lang=it" hreflang="it" />
    <link rel="alternate" href="/?lang=tr" hreflang="tr" />
    <link rel="alternate" href="/?lang=ru" hreflang="ru" />
    <link rel="alternate" href="/?lang=hi" hreflang="hi" />
    <link rel="alternate" href="/?lang=bn" hreflang="bn" />
    <link rel="alternate" href="/?lang=zh" hreflang="zh" />
    <link rel="alternate" href="/?lang=ja" hreflang="ja" />
    <link rel="alternate" href="/?lang=he" hreflang="he" />
    <link rel="alternate" href="/?lang=th" hreflang="th" />
    <link rel="alternate" href="/?lang=ro" hreflang="ro" />
    <link rel="alternate" href="/?lang=ka" hreflang="ka" />

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vue-multiselect@latest/dist/vue-multiselect.min.css">  
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/skeleton-screen-css@1.1.0/dist/index.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    {{-- <link href="{{ asset('assets/dist/css/tabler.min.css') }}" rel="stylesheet"/> --}}
    {{-- <link href="{{ asset('assets/dist/css/tabler-vendors.min.css') }}" rel="stylesheet"/> --}}
    <!-- Bootstrap CSS-->
    <link rel="stylesheet" href="{{ asset('front/vendor/bootstrap/css/bootstrap.min.css') }}">
    <!-- Ionicons CSS-->
    <link rel="stylesheet" href="{{ asset('front/css/ionicons.min.css') }}">
    <!-- Device mockups CSS-->
    <link rel="stylesheet" href="{{ asset('front/css/device-mockups.css') }}">
    <!-- Google fonts - Source Sans Pro-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,700">
    <!-- Swiper sLider-->
    <link rel="stylesheet" href="{{ asset('front/vendor/swiper/css/swiper.min.css') }}">
    <!-- theme stylesheet-->
    <link rel="stylesheet" href="{{ asset('front/css/style.default.css') }}" id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
    <link rel="stylesheet" href="{{ asset('front/css/custom.css') }}">
    <!-- Favicon-->
    <link rel="shortcut icon" href="{{ asset('front/img/favicon.png') }}">   
    <script src="https://cdn.jsdelivr.net/npm/vue@2"></script>
    <script src="https://cdn.jsdelivr.net/npm/vue-multiselect@2.1.8"></script>   
    <!-- Tweaks for older IEs--><!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script><![endif]-->
    <style>

      .ion-logo-tiktok {
        opacity: .5;
        transition: all 0.2s ease-in-out;
      }

      .ion-logo-tiktok:hover {
        opacity: 1;
      }

      .ion-logo-tiktok::before {
        content: '';
        width: 16px;
        height: 16px;
        display: inline-block;
        background: url("data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIGNsYXNzPSJpY29uIGljb24tdGFibGVyIGljb24tdGFibGVyLWJyYW5kLXRpa3RvayIgd2lkdGg9IjEwMCUiIGhlaWdodD0iMTAwJSIgdmlld0JveD0iMCAwIDI0IDI0IiBzdHJva2Utd2lkdGg9IjIiIHN0cm9rZT0iY3VycmVudENvbG9yIiBmaWxsPSJub25lIiBzdHJva2UtbGluZWNhcD0icm91bmQiIHN0cm9rZS1saW5lam9pbj0icm91bmQiPg0KICA8cGF0aCBzdHJva2U9Im5vbmUiIGQ9Ik0wIDBoMjR2MjRIMHoiIGZpbGw9Im5vbmUiIC8+DQogIDxwYXRoIGQ9Ik0yMSA3LjkxN3Y0LjAzNGE5Ljk0OCA5Ljk0OCAwIDAgMSAtNSAtMS45NTF2NC41YTYuNSA2LjUgMCAxIDEgLTggLTYuMzI2djQuMzI2YTIuNSAyLjUgMCAxIDAgNCAydi0xMS41aDQuMDgzYTYuMDA1IDYuMDA1IDAgMCAwIDQuOTE3IDQuOTE3eiIgLz4NCjwvc3ZnPg==");
      }

      .option__image{
        max-width: 1.5rem;
        max-height: 1.125rem;
      }
      .option__desc,.option__image{
        display:inline-block;
        vertical-align:middle;
      }
      .option__desc{
        padding:rem(10px);
      }
      .option__title{
        font-size:rem(24px);
      }
      .option__small{
        margin-top: rem(10px);
        display:block;
      }

      .multiselect__option--highlight {
        background: #540CFA;
      }

    </style>
    <style>
      #image-cover {
        max-width: 270px;
      }
    </style>    
    @stack('header-libs')
    @if ($data['header']['checked'])
        {!! $data['header']['code'] !!}
    @endif
  </head>
  <body>
    <!-- navbar-->
    @include('frontend.header')
    {{ $slot }}
    @include('frontend.footer')
    <!-- JavaScript files-->
    <script src="{{ asset('front/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('front/vendor/popper.js/umd/popper.min.js') }}"> </script>
    <script src="{{ asset('front/vendor/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('front/vendor/jquery.cookie/jquery.cookie.js') }}"> </script>
    <script src="{{ asset('front/vendor/swiper/js/swiper.min.js') }}"></script>
    <script src="{{ asset('front/js/front.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    @stack('footer-libs')
    @if ($data['footer']['checked'])
        {!! $data['footer']['code'] !!}
    @endif    
  </body>
</html>    
