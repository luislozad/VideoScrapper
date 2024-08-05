@php
  $allLanguages = [];
  $languages = [];
  $langShortNames = [];

  $translateAPI = false;

  try {
    $languages = App\Models\Language::all()
    ->filter(function($lang) {
      return $lang->enabled === 1;
    });
    $langShortNames = $languages
    ->map(function($lang) {
      return $lang->shortName;
    })
    ->values();
    // Debugbar::info($langShortNames->toArray());
  } catch (\Throwable $th) {
    //throw $th;
    Log::info("info-multi (Language::all): $th");
  }

  try {
     $cloudTranslate = App\Models\GoogleCloudTranslationApi::first();
     $translateAPI = $cloudTranslate ? true : false;
  } catch (\Throwable $th) {
    Log::info("info-multi (GoogleCloudTranslationApi::first(): $th");
  }

 foreach ($languages as $lang) {
  if ($lang->enabled === 1) {
    $allLanguages[$lang->shortName] = $lang;
  }
 }
@endphp

@push('head-libs')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.3/dist/sweetalert2.min.css">
@endpush

@push('head-libs')
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">    
@endpush

<div class="card" x-data="{
  allLanguages: {{ Js::from($allLanguages) }},
  languageCurrent: '{{ $langCurrent }}',
  lang: {{ Js::from($langData) }},
  loadAutoTranslate: false,
  targetTranslation: '',
  flash: () => {
    return new Notyf({
      position: {
          x: 'center',
          y: 'top',
      },
      dismissible: true,       
    }); 
  },
  saveLanguage: async function() {
    this.loadAutoTranslate = true;

    const { languageCurrent } = this;

    this.targetTranslation = `<span>{{ __('Saving:') }} <span class='flag flag-xs ${this.allLanguages[languageCurrent]['icon']}'></span> ${this.allLanguages[languageCurrent]['fullName']}</span>`;
    
    const langData = this.lang[languageCurrent];

    const isLocalTranslate = await $wire.saveTranslate({
      lang: languageCurrent,
      translate: {
        'Website title': langData['title'],
        'Website description': langData['description'],
        'Website keywords': langData['keywords'],
      },
    });

    if (!isLocalTranslate) {
      this.flash().error(`@php echo Html::htmlEntityDecodeUTF8(__('There was an error when saving the language:')); @endphp ${this.allLanguages[languageCurrent]['fullName']}`);
      loadAutoTranslate = false;
      targetTranslation = '';
      return;
    }

    this.flash().success(`@php echo Html::htmlEntityDecodeUTF8(__('Your changes have been successfully saved!')); @endphp`);

    this.loadAutoTranslate = false;
    this.targetTranslation  = '';
  },
  flashAlert: function() {
    return {
      error: function(text) {
        Swal.fire({
          text,
          icon: 'error',
          title: 'Oops...',
          footer: `<a href=\'{{ route('admin.translate-api') }}\'>{{ __('Translate API') }}</a>`
        });           
      }
    } 
  }
}">

    <div class="card-header justify-between">
        <h4 class="card-title">{{ __('Multilingual Information') }}</h4>
        <div wire:ignore>
          <select type="text" class="form-select multi-languages" value="{{ $langCurrent }}" x-model="languageCurrent">
            @foreach ($languages as $lang)
              <option value="{{ $lang->shortName }}" data-custom-properties="&lt;span class=&quot;flag flag-xs {{ $lang->icon }}&quot;&gt;&lt;/span&gt;" >{{ $lang->fullName }}</option>  
            @endforeach
          </select>    
        </div>
    </div>    

    <div class="card-body">
      <x-errors :errors="$errors" /> 

      <div x-show="!loadAutoTranslate">
          <div class="mb-3 w-full">
              <label class="form-label">{{ __('Page Title') }}</label>
              <input type="text" class="form-control" placeholder="{{ __('Web page title') }}" x-model="lang[languageCurrent].title">
          </div>     
          
          <div class="mb-3 w-full">
              <label class="form-label">{{ __('Site Description (SEO)') }}</label>
              <input type="text" class="form-control" placeholder="{{ __('Website description in the metadata') }}" x-model="lang[languageCurrent].description">
          </div> 
          
          <div class="mb-3 w-full">
              <label class="form-label">{{ __('Keywords (SEO)') }}</label>
              <input type="text" class="form-control" placeholder="{{ __('Keywords must be separated by commas') }}" x-model="lang[languageCurrent].keywords">
          </div>  
      </div>

      <div class="mb-3 w-full" style="display: none;" x-show="loadAutoTranslate">
        <label class="form-label"><span x-html="targetTranslation"></span></label>
        <x-admin.progress-infinite />
      </div>
      
      
      <div class="col-auto ms-auto d-print-none w-full flex justify-end" x-data="{
        popLanguageCurrent: '{{ $langCurrent }}', 
        selectedLanguage: {{ Js::from($langShortNames) }},
        handleLang: function() {
          if (this.selectedLanguage.length > 0) {
            this.selectedLanguage = [];
          } else {
            this.selectedLanguage = {{ Js::from($langShortNames) }};
          }
        },
        autoTranslate: async function() {
          loadAutoTranslate = true;
          const langCurrent = this.popLanguageCurrent;

          const languages = [];

          for (const lang of this.selectedLanguage) {
            languages.push(lang);
          }

          const filterLang = languages.filter((lang) => lang !== langCurrent);

          const dataLangCurrent = lang[langCurrent];

          const isLocalTranslate = await $wire.saveTranslate({
            lang: langCurrent,
            translate: {
              'Website title': dataLangCurrent['title'],
              'Website description': dataLangCurrent['description'],
              'Website keywords': dataLangCurrent['keywords'],
            },
          });

          if (!isLocalTranslate) {
            flash().error(`@php echo Html::htmlEntityDecodeUTF8(__('There was an error when saving the local language')); @endphp`);
            loadAutoTranslate = false;
            targetTranslation = '';
            return;
          };          

          for (const langCode of filterLang) {
            const langData = {
              langFrom: langCurrent,
              langTo: langCode,
              translate: {
                'Website title': lang[langCurrent].title,
                'Website description': lang[langCurrent].description,
                'Website keywords': lang[langCurrent].keywords,
              }
            };

            targetTranslation = `<span>{{ __('Translate') }}: <span class='flag flag-xs ${allLanguages[langCode]['icon']}'></span> ${allLanguages[langCode]['fullName']}</span>`;

            const isTranslate = await $wire.autoTranslate(langData);

            if (!isTranslate) {
              flash().error(`@php echo Html::htmlEntityDecodeUTF8(__('There was an error when translating the language:')); @endphp ${langCode}`);             
            }
          }

          targetTranslation = `<span>{{ __('Updating UI') }}</span>`;

          const newLangData = await $wire.getLangData();

          if (!newLangData) {
            flash().error(`@php echo Html::htmlEntityDecodeUTF8(__('There was an error while updating the UI')); @endphp`);  
            return;
          }

          lang = newLangData;

          flash().success(`@php echo Html::htmlEntityDecodeUTF8(__('Your changes have been successfully saved!')); @endphp`);

          loadAutoTranslate = false;
          targetTranslation = '';
        },
        modalSave: function() {
          this.autoTranslate();
        },
        modalCancel: function() {
        },
        modalClose: function() {
        },
        modalButtonClick: function() {
        },
        handleGoogleApi: function() {
          flashAlert().error(`@php echo Html::htmlEntityDecodeUTF8(__('Sorry, you have not yet provided a valid key in:')); @endphp @php echo Html::htmlEntityDecodeUTF8(__('Translate API')); @endphp`);
        }
      }">
          <div class="btn-list">
            <x-admin.button-modal title="{{ __('Auto Translation') }}" id="modal-auto-translation">
              @if ($translateAPI)
                <a class="btn btn-secondary d-sm-inline-block" x-show.important="!loadAutoTranslate">
                  <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-language" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 5h7" /><path d="M9 3v2c0 4.418 -2.239 8 -5 8" /><path d="M5 9c0 2.144 2.952 3.908 6.7 4" /><path d="M12 20l4 -9l4 9" /><path d="M19.1 18h-6.2" /></svg>
                  {{ __('Auto Translation') }}
                </a>
                <button class="btn btn-secondary d-sm-inline-block" style="display: none !important;" x-show.important="loadAutoTranslate" disabled>
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-language" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 5h7" /><path d="M9 3v2c0 4.418 -2.239 8 -5 8" /><path d="M5 9c0 2.144 2.952 3.908 6.7 4" /><path d="M12 20l4 -9l4 9" /><path d="M19.1 18h-6.2" /></svg>
                  {{ __('Auto Translation') }}                
                </button>
              @else
                <button class="btn btn-secondary d-sm-inline-block" :disabled="loadAutoTranslate" @click="handleGoogleApi()">
                  <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-language" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 5h7" /><path d="M9 3v2c0 4.418 -2.239 8 -5 8" /><path d="M5 9c0 2.144 2.952 3.908 6.7 4" /><path d="M12 20l4 -9l4 9" /><path d="M19.1 18h-6.2" /></svg>
                  {{ __('Auto Translation') }}                
                </button>                
              @endif
              <x-slot:modal>
                <div class="row row-cards divide-x">
                  <div class="col-md-6">
                    <div class="card card-borderless">
                      <div class="card-body" wire:ignore>
                        <h3 class="card-title">{{ __('Translate from') }}</h3>
                        <select type="text" class="form-select multi-languages" value="{{ $langCurrent }}" x-model="popLanguageCurrent">
                          @foreach ($languages as $lang)
                            <option value="{{ $lang->shortName }}" data-custom-properties="&lt;span class=&quot;flag flag-xs {{ $lang->icon }}&quot;&gt;&lt;/span&gt;">{{ $lang->fullName }}</option>  
                          @endforeach
                        </select> 
                      </div>
                    </div>  
                    <div class="card card-borderless">
                      <div class="card-body">
                        <div class="card" style="padding: 12px;">
                          <div>
                            <div class="mb-3 w-full">
                                <label class="form-label">{{ __('Page Title') }}</label>
                                <input type="text" class="form-control" placeholder="{{ __('Web page title') }}" x-model="lang[popLanguageCurrent].title">
                            </div>     
                            
                            <div class="mb-3 w-full">
                                <label class="form-label">{{ __('Site Description (SEO)') }}</label>
                                <input type="text" class="form-control" placeholder="{{ __('Website description in the metadata') }}" x-model="lang[popLanguageCurrent].description">
                            </div> 
                            
                            <div class="mb-3 w-full">
                                <label class="form-label">{{ __('Keywords (SEO)') }}</label>
                                <input type="text" class="form-control" placeholder="{{ __('Keywords must be separated by commas') }}" x-model="lang[popLanguageCurrent].keywords">
                            </div>  
                        </div>
                        </div>
                      </div>
                    </div>                  
                  </div>
                  <div class="col-md-6">
                    <div class="card card-borderless">
                      <div class="card-body">
                        <h3 class="card-title">{{ __('Translate to') }}</h3>
                        <div class="card" style="max-height: 405px;">
                          <div class="table-responsive">
                            <table class="table table-vcenter card-table">
                              <thead>
                                <tr>
                                  <th>{{ __('Languages') }}</th>
                                  <th class="w-1">
                                    <input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices" checked @click="handleLang()">
                                  </th>
                                </tr>
                              </thead>
                              <tbody>
                                @foreach ($languages as $lang)
                                <tr style="display: {{ $lang->shortName !== $langCurrent ? 'table-row' : 'none' }};" x-show="popLanguageCurrent !== '{{ $lang->shortName }}'">
                                  <td>
                                    <span class="flag flag-xs {{ $lang->icon }}"></span>
                                    {{ $lang->fullName }}
                                  </td>
                                  <td>
                                    <label class="form-check">
                                      <input value="{{ $lang->shortName }}" class="form-check-input" type="checkbox" x-model="selectedLanguage">
                                      {{-- {{ debug($lang->shortName) }} --}}
                                    </label>
                                  </td>
                                </tr>
                                @endforeach
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>                               
              </x-slot>
            </x-admin.button-modal>
            <button class="btn btn-primary d-sm-inline-block" :disabled="loadAutoTranslate" @click="saveLanguage()">
              <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
              <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-device-floppy" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2" /><path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M14 4l0 4l-6 0l0 -4" /></svg>
              {{ __('Save') }}
            </button>
          </div>
      </div>        
    </div>

</div>

@push('footer-libs')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.3/dist/sweetalert2.all.min.js"></script>
@endpush

@push('footer-libs')
<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
@endpush

@push('footer-libs')
<script>
  // @formatter:off
  document.addEventListener("DOMContentLoaded", function () {
    if (window.TomSelect) {
      const languages = document.querySelectorAll('.multi-languages');

      languages.forEach((element) => {
        new TomSelect(element, {
          items: ["{{ $langCurrent }}"],
          copyClassesToDropdown: false,
          dropdownParent: 'body',
          controlInput: '<input>',
          render:{
            item: function(data,escape) {
              if( data.customProperties ){
                return '<div><span class="dropdown-item-indicator">' + data.customProperties + '</span>' + escape(data.text) + '</div>';
              }
              return '<div>' + escape(data.text) + '</div>';
            },
            option: function(data,escape){
              if( data.customProperties ){
                return '<div><span class="dropdown-item-indicator">' + data.customProperties + '</span>' + escape(data.text) + '</div>';
              }
              return '<div>' + escape(data.text) + '</div>';
            },
          },
        });      
      });

      const lang2 = document.querySelector('#tomselect-2-ts-dropdown');

      if (!lang2) return;

      const container = lang2.closest('.ts-dropdown');

      if (!container) return;

      container.style.zIndex = '2000';
    }
  });
  // @formatter:on
</script>    
@endpush