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
    {{-- <title>{{ config('app.name', 'Laravel') }}</title> --}}
    <title>Sign in - Video Scraper</title>
    <!-- CSS files -->
    <link href="{{ asset("assets/dist/css/tabler.min.css") }}" rel="stylesheet"/>
    <link href="{{ asset("assets/dist/css/tabler-flags.min.css") }}" rel="stylesheet"/>
    <link href="{{ asset("assets/dist/css/tabler-payments.min.css") }}" rel="stylesheet"/>
    <link href="{{ asset("assets/dist/css/tabler-vendors.min.css") }}" rel="stylesheet"/>
    <link href="{{ asset("assets/dist/css/demo.min.css") }}" rel="stylesheet"/>
    <style>
      @import url('https://rsms.me/inter/inter.css');
      :root {
      	--tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
      }
      body {
      	font-feature-settings: "cv03", "cv04", "cv11";
      }
    </style>

    <!-- Scripts -->
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js'])     --}}
  </head>
  <body  class=" d-flex flex-column">
    <script src="{{ asset("assets/dist/js/demo-theme.min.js") }}"></script>
    <div class="page page-center">
        {{ $slot }}
    </div>
    <!-- Libs JS -->
    <!-- Tabler Core -->
    <script src="{{ asset("assets/dist/js/tabler.min.js") }}" defer></script>
    <script src="{{ asset("assets/dist/js/demo.min.js") }}" defer></script>
    @stack('script-footer')
  </body>
</html>
