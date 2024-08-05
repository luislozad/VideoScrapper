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

<!doctype html>
<!--
* Tabler - Premium and Open Source dashboard template with responsive and high quality UI.
* @version 1.0.0-beta19
* @link https://tabler.io
* Copyright 2018-2023 The Tabler Authors
* Copyright 2018-2023 codecalm.net Paweł Kuna
* Licensed under MIT (https://github.com/tabler/tabler/blob/master/LICENSE)
-->
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $appName }}</title>
    <!-- CSS files -->
	@vite(['resources/css/styles.css'])
    <link href="{{ asset('assets/dist/css/tabler.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('assets/dist/css/tabler-flags.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('assets/dist/css/tabler-payments.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('assets/dist/css/tabler-vendors.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('assets/dist/css/demo.min.css') }}" rel="stylesheet"/>
	{{-- <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script> --}}
	{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js --}}
    <style>
      @import url('https://rsms.me/inter/inter.css');
      :root {
      	--tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
      }
      body {
      	font-feature-settings: "cv03", "cv04", "cv11";
      }
    </style>
    <style>
      @media (max-width: 991.98px) {
        .headerTop {
          display: none;
        }
      }

      aside > .container-fluid .userprofile {
        display: none !important;
      }

      @media (max-width: 991.98px) {
        aside > .container-fluid .userprofile {
          display: flex !important;
        }
      }      
    </style>    
    @stack('head-libs')
  </head>
  <body >
	<main>
		<div class="page">
		  <!-- Sidebar -->
		  <x-admin.navbar />
		  <div class="page-wrapper">
			<!-- Page header -->
			<x-admin.header />
			<!-- Page body -->
			<div class="page-body">
			  <div class="container-xl">
				{{ $slot }}
			  </div>
			</div>
			<x-admin.footer />
		  </div>
		</div>
	</main>
  <script src="{{ asset('assets/dist/libs/tom-select/dist/js/tom-select.base.min.js') }}" defer></script>
    <script src="{{ asset('assets/dist/js/demo-theme.min.js') }}"></script>
    <!-- Libs JS -->
    {{-- <script src="{{ asset('assets/dist/libs/apexcharts/dist/apexcharts.min.js') }}" defer></script>
    <script src="{{ asset('assets/dist/libs/jsvectormap/dist/js/jsvectormap.min.js') }}" defer></script>
    <script src="{{ asset('assets/dist/libs/jsvectormap/dist/maps/world.js') }}" defer></script>
    <script src="{{ asset('assets/dist/libs/jsvectormap/dist/maps/world-merc.js') }}" defer></script> --}}
    <!-- Tabler Core -->
    <script src="{{ asset('assets/dist/js/tabler.min.js') }}" defer></script>
    <script src="{{ asset('assets/dist/js/demo.min.js') }}" defer></script>
    @stack('footer-libs')  
  </body>
</html>