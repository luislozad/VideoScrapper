@push('head-libs')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.3/dist/sweetalert2.min.css">
@endpush

<div class="card" x-data="{
    siteLanguage: '{{ $languageCurrent }}',
    handleLang: function() {
        if (this.selectedLanguage.length > 0) {
            this.selectedLanguage = [];
        } else {
            this.selectedLanguage = {{ Js::from($shortNames) }};
        }        
    },
    savingData: false,
    selectedLanguage: {{ Js::from($enabledLanguages) }}, 
    saveAll: async function() {
        const allLanguages = {{ Js::from($shortNames) }};

        const { selectedLanguage } = this;

        const languages = {};

        this.savingData = true;

        for (const lang of allLanguages) {
            languages[lang] = {
              enabled: false,
              active: this.siteLanguage === lang,
            };
        }

        if (Object.keys(selectedLanguage).length === 0) {
          this.flashAlert().warning(`@php echo Html::htmlEntityDecodeUTF8(__('Before saving the data, you must select a new default language')); @endphp`);
          this.savingData = false;
          return;
        }

        for (const lang of selectedLanguage) {
            languages[lang]['enabled'] = true;
        }

        let save = true;



        for (const lang in languages) {
          const langData = languages[lang];

          if (!langData.enabled) {
            save = langData.active === false;
            if (!save) {
              break;
            }
          }
        }

        if (save) {
          await $wire.save(languages);
        } else {
          this.flashAlert().warning(`@php echo Html::htmlEntityDecodeUTF8(__('Before saving the data, you must select a new default language')); @endphp`);
        }

        this.savingData = false;
    },
    flashAlert: function() {
      return {
        warning: function(text) {
          Swal.fire({
            text,
            icon: 'warning',
            title: 'Oops...',
          });           
        }
      } 
    }    
}">
    <div class="card-header flex justify-between sticky-top" style="background-color: white;">
        <h4 class="card-title">{{ __('Enabled languages') }}</h4>
        <div class="btn-list">
            <button class="btn btn-primary d-sm-inline-block" @click="saveAll()" :disabled="savingData">
                <div class="spinner-border spinner-border-sm" role="status" style="display: none;" x-show="savingData"></div>
                <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                <svg x-show="!savingData" xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-device-floppy" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2" /><path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M14 4l0 4l-6 0l0 -4" /></svg>
                {{ __('Save') }}
            </button>
        </div>   
    </div>  

    <div class="card-body">
        <x-errors :errors="$errors" /> 

        <div class="table-responsive">
            <table class="table table-vcenter card-table">
              <thead>
                <tr>
                  <th>{{ __('Languages') }}</th>
                  <th class="w-1">{{ __('Site language') }}</th>
                  <th class="w-1">
                    <input class="form-check-input m-0 align-middle" type="checkbox" aria-label="Select all invoices" checked @click="handleLang()">
                  </th>
                </tr>
              </thead>
              <tbody>
                @foreach ($languages as $lang)
                <tr>
                  <td>
                    <span class="flag flag-xs {{ $lang->icon }}"></span>
                    {{ $lang->fullName }}
                  </td>
                  <td>
                    <label class="form-colorinput form-colorinput-light" style="display: block; margin: 0 auto; max-width: min-content; position: relative; top: -4px;">
                      <input name="siteLanguage" type="radio" value="{{ $lang->shortName }}" class="form-colorinput-input" x-model="siteLanguage">
                      <span class="form-colorinput-color bg-white" style="width: 1rem; height: 1rem;"></span>
                    </label>
                  </td>                  
                  <td>
                    <label class="form-check">
                      <input value="{{ $lang->shortName }}" class="form-check-input" type="checkbox" x-model="selectedLanguage">
                    </label>
                  </td>
                </tr>
                @endforeach
              </tbody>
            </table>
          </div>        
    </div>
</div>

@push('footer-libs')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.10.3/dist/sweetalert2.all.min.js"></script>
@endpush