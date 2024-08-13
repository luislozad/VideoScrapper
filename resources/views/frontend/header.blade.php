@php
    $logo = 'assets/static/logo.svg';
    $langCurrent = [];
    $languages = [];
    $selectOpts = [];

    $defaultLang = app()->getLocale();
    
    try {
      $page = App\Models\Page::first();
      if ($page) {
        $logo = $page->logo ? "storage/$page->logo" : $logo;
      }
    } catch (\Throwable $th) {
      Log::info($th);
    }

    try {
      $languages = App\Utils\Language::getAllLanguages();

      foreach ($languages as $lang) {
        if ($lang->shortName === $defaultLang) {
          $icon = explode('-', $lang->icon)[2];
          $langCurrent = [
            'title' => $lang->fullName,
            'code' => $lang->shortName,
            'img' => asset("assets/dist/img/flags/$icon.svg"),
          ];

          break;
        }
      }
    } catch (\Throwable $th) {
      Log::info($th);
    }
    
    try {
      foreach ($languages as $lang) {
        $icon = explode('-', $lang->icon)[2];
        $selectOpts[] = [
          'title' => $lang->fullName,
          'code' => $lang->shortName,
          'img' => asset("assets/dist/img/flags/$icon.svg"),
        ];
      }
    } catch (\Throwable $th) {
      Log::info($th);
    }
@endphp

<header class="header">
    <nav class="navbar navbar-expand-lg">
      <div class="container">
        <!-- Navbar brand--><a href="{{ route('home') }}" class="navbar-brand font-weight-bold"><img src="{{ asset($logo) }}" alt="..." class="img-fluid"></a>
        <!-- Navbar toggler button-->
        {{-- <button type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation" class="navbar-toggler navbar-toggler-right">Menu<i class="icon ion-md-list ml-2"></i></button>
        <div id="navbarSupportedContent" class="collapse navbar-collapse">
          <ul class="navbar-nav mx-auto ml-auto">
                <!-- Link-->
                <li class="nav-item"> <a href="schedule.html" class="nav-link">What's on</a></li>
                <!-- Link-->
                <li class="nav-item"> <a href="text.html" class="nav-link">Text Page</a></li>
                <!-- Link-->
                <li class="nav-item"> <a href="#" class="nav-link">Get started</a></li>
            <li class="nav-item dropdown"><a id="pages" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" class="nav-link dropdown-toggle">Pages</a>
              <div class="dropdown-menu"><a href="index.html" class="dropdown-item">Home</a><a href="schedule.html" class="dropdown-item">What's on</a><a href="text.html" class="dropdown-item">Text Page</a></div>
            </li>
          </ul> --}}

          <ul class="navbar-nav">
            <div wire:ignore>
              <div id="app-multiselect">
                <vue-multiselect v-model="value" label="title" track-by="title" :options="options" :custom-label="customLabel" :show-labels="false" placeholder="{{ __('Select option') }}"  @input="onChange">
                  @verbatim
                    <template slot="singleLabel" slot-scope="props">
                      <img class="option__image" :src="props.option.img">
                      <span class="option__desc">
                        <span class="option__title">{{ props.option.title }}</span>
                      </span>
                    </template>
                    <template slot="option" slot-scope="props">
                      <img class="option__image" :src="props.option.img">
                      <div class="option__desc">
                        <span class="option__title">{{ props.option.title }}
                        </span>
                      </div>
                    </template>                    
                  </vue-multiselect>
              </div> 
              @endverbatim  
            </div> 
          </ul>          
        </div>
      </div>
    </nav>
  </header>

  @push('footer-libs')
  <script>
    // @formatter:off
    new Vue({
        el: '#app-multiselect',
        components: {
            'vue-multiselect': window.VueMultiselect.default
        },
        data() {
            return {
                value: {{ Js::from($langCurrent) }},
                options: {{ Js::from($selectOpts) }}
            }
        },
        methods: {
          customLabel ({ title }) {
            return `${title}`
          },
          onChange ({ code }) {
            this.newLang(code);
          },
          newLang(lang) {
            const fullPath = window.location.origin + window.location.pathname;
            const urlParams = new URLSearchParams(window.location.search);
            urlParams.set('lang', lang);
            
            const newUrl = `${fullPath}?${urlParams.toString()}`;
            
            window.location.href = newUrl;            
          }
        }        
    });
    // @formatter:on
  </script>       
  @endpush