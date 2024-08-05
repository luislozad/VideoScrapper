@push('head-libs')
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">    
@endpush

@push('head-libs')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.3/dist/sweetalert2.min.css">
@endpush

<div class="card" x-data="{
    langCurrent: '{{ $langCurrent }}',
    popLangCurrent: '{{ $langCurrent }}',
    langData: {{ Js::from($data) }},
    selectedLanguage: {{ Js::from($shortNames) }},
    loadAutoTranslate: false,
    targetTranslation: '',
    saveLanguage: async function() {   
        this.loadAutoTranslate = true;

        const { langCurrent } = this;
    
        this.targetTranslation = `<span>{{ __('Saving:') }} <span class='flag flag-xs ${this.langData[langCurrent]['icon']}'></span> ${this.langData[langCurrent]['fullName']}</span>`;
        
        const translate = JSON.parse(JSON.stringify(Object.assign({}, this.langData[langCurrent]['content'])));
    
        const isLocalTranslate = await $wire.saveTranslate({
            translate,
            lang: langCurrent,
        });
    
        if (!isLocalTranslate) {
          this.flash().error('{{ __('There was an error when saving the language:') }}' + ' ' + this.langData[langCurrent]['fullName']);
          this.loadAutoTranslate = false;
          this.targetTranslation = '';
          return;
        }
    
        this.flash().success('{{ __('Your changes have been successfully saved!') }}');
    
        this.loadAutoTranslate = false;
        this.targetTranslation  = '';        
    },
    handleGoogleApi: function() {
        this.flashAlert().error('{{ __('Sorry, you have not yet provided a valid key in:') }} {{ __('Translate API') }}');
    },
    handleAutoTranslate: async function() {
        this.loadAutoTranslate = true;
        const langCurrent = this.popLangCurrent;

        const languages = [];

        for (const lang of this.selectedLanguage) {
            languages.push(lang);
        }

        const filterLang = languages.filter((lang) => lang !== langCurrent);

        const translate = this.langData[langCurrent]['content'];

        const isLocalTranslate = await $wire.saveTranslate({
            lang: langCurrent,
            translate,
        });

        if (!isLocalTranslate) {
            this.flash().error('{{ __('There was an error when saving the local language') }}');
            this.loadAutoTranslate = false;
            this.targetTranslation = '';
            return;
        };          

        for (const langCode of filterLang) {
            const langData = {
                langFrom: langCurrent,
                langTo: langCode,
                translate,
            };

            this.targetTranslation = `<span>{{ __('Translate') }}: <span class='flag flag-xs ${this.langData[langCode]['icon']}'></span> ${this.langData[langCode]['fullName']}</span>`;

            const isTranslate = await $wire.autoTranslate(langData);

            if (!isTranslate) {
                this.flash().error('{{ __('There was an error when translating the language:') }}' + ' ' + langCode);             
            }
        }

        this.targetTranslation = '<span>{{ __('Updating UI') }}</span>';

        const newLangData = await $wire.getLangData();

        if (!newLangData) {
            this.flash().error('{{ __('There was an error while updating the UI') }}');  
            return;
        }

        this.langData = newLangData;

        this.flash().success('{{ __('Your changes have been successfully saved!') }}');

        this.loadAutoTranslate = false;
        this.targetTranslation = '';
    },
    selectLanguages: function() {
        if (this.selectedLanguage.length > 0) {
            this.selectedLanguage = [];
        } else {
            const languages = {{ Js::from($shortNames) }};
            this.selectedLanguage = languages;
        }
    },
    modalButtonClick: function() {
    },
    modalClose: function() {
    },
    modalSave: function() {
        this.handleAutoTranslate();
    },
    modalCancel: function() {
    },
    flash: () => {
        return new Notyf({
            position: {
                x: 'center',
                y: 'top',
            },
            dismissible: true,       
        }); 
    },
    flashAlert: function() {
        return {
            warning: function(text) {
                Swal.fire({
                    text,
                    icon: 'warning',
                    title: 'Oops...',
                });           
            },
            error: function(text) {
                Swal.fire({
                    text,
                    icon: 'error',
                    title: 'Oops...',
                    footer: '<a href=\'{{ route('admin.translate-api') }}\'>{{ __('Translate API') }}</a>'
                });           
            }               
        };
     
    }             
}">

    <x-errors :errors="$errors" /> 

    <div class="card-header flex justify-between">
        <h4 class="card-title">{{ __('Template Content') }}</h4>
        <div wire:ignore>
            <select type="text" class="form-select multi-languages" value="{{ $langCurrent }}" x-model="langCurrent">
              @foreach ($data as $lang)
                <option value="{{ $lang['shortName'] }}" data-custom-properties="&lt;span class=&quot;flag flag-xs {{ $lang['icon'] }}&quot;&gt;&lt;/span&gt;" >{{ $lang['fullName'] }}</option>  
              @endforeach
            </select>    
        </div>        
    </div>

    <div class="card-body">
        <div class="card">
            <div class="table-responsive" x-show="!loadAutoTranslate">
                <table class="table table-vcenter card-table">
                  <thead>
                    <tr>
                      <th>{{ __('Text') }}</th>
                      <th>{{ __('Value') }}</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($data[$langCurrent]['content'] as $key => $value)
                    <tr>
                        <td >{{ $key }}</td>
                        <td class="text-muted" >
                            <input type="text" class="form-control" name="example-text-input" x-model="langData[langCurrent]['content']['{{ $key }}']">
                        </td>
                    </tr>
                    @endforeach
                  </tbody>
                </table>
            </div>

            <div class="mb-3 w-full flex items-start p-4 flex-col" style="display: none;" x-show="loadAutoTranslate">
                <label class="form-label"><span x-html="targetTranslation"></span></label>
                <x-admin.progress-infinite />
            </div>            
            <div class="btn-list card-footer flex justify-end">
                <x-admin.button-modal title="{{ __('Auto Translation') }}" id="modal-auto-translation" modalType="full">
                    @if ($translateAPI)
                      <a class="btn btn-secondary d-sm-inline-block" x-show.important="!loadAutoTranslate" style="margin-right: 4px;">
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
                        <div class="col-md-8">
                          <div class="card card-borderless">
                            <div class="card-body" wire:ignore>
                              <h3 class="card-title">{{ __('Translate from') }}</h3>
                              <select type="text" class="form-select multi-languages" value="{{ $langCurrent }}" x-model="popLangCurrent">
                                @foreach ($data as $lang)
                                  <option value="{{ $lang['shortName'] }}" data-custom-properties="&lt;span class=&quot;flag flag-xs {{ $lang['icon'] }}&quot;&gt;&lt;/span&gt;">{{ $lang['fullName'] }}</option>  
                                @endforeach
                              </select> 
                            </div>
                          </div>  
                          <div class="card card-borderless">
                            <div class="card-body">
                              <div class="card" style="padding: 12px;">
                                <div class="table-responsive">
                                    <table class="table table-vcenter card-table">
                                      <thead>
                                        <tr>
                                          <th>{{ __('Text') }}</th>
                                          <th>{{ __('Value') }}</th>
                                        </tr>
                                      </thead>
                                      <tbody>
                                        @foreach ($data[$langCurrent]['content'] as $key => $value)
                                        <tr>
                                            <td >{{ $key }}</td>
                                            <td class="text-muted" >
                                                <input type="text" class="form-control" name="example-text-input" x-model="langData[popLangCurrent]['content']['{{ $key }}']">
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
                        <div class="col-md-4">
                          <div class="card card-borderless">
                            <div class="card-body">
                              <h3 class="card-title">{{ __('Translate to') }}</h3>
                              <div class="card">
                                <div class="table-responsive">
                                  <table class="table table-vcenter card-table">
                                    <thead>
                                      <tr>
                                        <th>{{ __('Languages') }}</th>
                                        <th class="w-1">
                                          <input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices" checked @click="selectLanguages()">
                                        </th>
                                      </tr>
                                    </thead>
                                    <tbody>
                                      @foreach ($data as $lang)
                                      <tr style="display: {{ $lang['shortName'] !== $langCurrent ? 'table-row' : 'none' }};" x-show="popLangCurrent !== '{{ $lang['shortName'] }}'">
                                        <td>
                                          <span class="flag flag-xs {{ $lang['icon'] }}"></span>
                                          {{ $lang['fullName'] }}
                                        </td>
                                        <td>
                                          <label class="form-check">
                                            <input value="{{ $lang['shortName'] }}" class="form-check-input" type="checkbox" x-model="selectedLanguage">
                                            {{-- {{ debug($lang['shortName']) }} --}}
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

@push('footer-libs')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.3/dist/sweetalert2.all.min.js"></script>
@endpush

@push('footer-libs')
<script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
@endpush