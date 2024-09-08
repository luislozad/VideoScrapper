<div>

  <div class="mb-3">
    <x-pg-media-downloader::views.parts.multi-select 
    label="Platforms"
    options="step1Options"
    handlerClickOption="onStep1PlatformOptionClick"
    handlerChange="onStep1PlatformChange"
    />
    <x-pg-media-downloader::views.parts.invalid 
    show="showPlatformSelErr"
    errHighlight="errHighlight">
      {{ __('No platform has been selected yet') }}
    </x-pg-media-downloader::views.parts.invalid>
  </div>
  
    
    <div class="row">
        <div class="col-lg-8">
          <div class="mb-3">
            <label class="form-label">{{ __('Title') }}</label>
            <input type="text" class="form-control" placeholder="e.g. Rapidapi" x-model="titleNewApi" />
            <x-pg-media-downloader::views.parts.invalid 
            show="showInvalidTitleMsg"
            errHighlight="errHighlight">
              {{ __('No title has been supplied yet') }}
            </x-pg-media-downloader::views.parts.invalid>         
          </div>
        </div>
        <div class="col-lg-4">
          <div class="mb-3">

            <div class="form-label">{{ __('Status') }}</div>
            <div>
              <label class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="radios-inline" checked="">
                <span class="form-check-label">{{ __('Enabled') }}</span>
              </label>
              <label class="form-check form-check-inline">
                <input class="form-check-input" type="radio" name="radios-inline">
                <span class="form-check-label">{{ __('Disabled') }}</span>
              </label>
            </div>
          </div>
        </div>

        <div class="col-lg-12">
          <div>
            <label class="form-label">{{ __('Additional information') }}</label>
            <textarea class="form-control" rows="3"></textarea>
          </div>
        </div>        
    </div>


</div>