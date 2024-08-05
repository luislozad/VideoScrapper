<form class="card" wire:submit="save">
    <div class="card-header">
        <h4 class="card-title">{{ __('Application') }}</h4>
    </div>
    <div class="card-body">
        <x-errors :errors="$errors" />  
            
        <div class="mb-3 w-full">
            <label class="form-label">{{ __('App Name') }}</label>
            <input type="text" class="form-control" placeholder="{{ __('Your application name') }}" wire:model="appName" autofocus>
        </div> 
        
        <div class="flex flex-col">
            <div class="mb-3">
                <div class="form-label">{{ __('Logo') }}</div>
                <div class="row g-2">
                    <div class="col">
                        <input type="file" class="form-control" wire:model="logo" accept=".png,.jpg,.svg" />               
                    </div>
                    
                    <div class="col-auto align-self-center">
                        <span class="form-help" data-bs-toggle="popover" data-bs-placement="top" data-bs-content="<p>{{ __('It is recommended to use images in SVG format.') }}</p>" data-bs-html="true">?</span>
                    </div> 
                </div>

                @if ($logo) 
                    <img src="{{ $logo->temporaryUrl() }}" style="max-width: 400px; margin-top: 20px">
                @elseif($logoUrl)
                    <img src="{{ asset("storage/$logoUrl") }}" style="max-width: 400px; margin-top: 20px">
                @endif                  
            </div>

            <div class="mb-3">
                <div class="form-label">{{ __('Icon') }}</div>
                <div class="row g-2">
                    <div class="col">
                        <input type="file" class="form-control" wire:model="icon" accept=".png,.jpg,.gif" />               
                    </div>
                    
                    <div class="col-auto align-self-center">
                        <span class="form-help" data-bs-toggle="popover" data-bs-placement="top" data-bs-content="<p>{{ __('The standard size for favicons is 16x16 pixels, but most designers start with 32x32 pixels to accommodate retina screens.') }}</p>" data-bs-html="true">?</span>
                    </div> 
                </div>

                @if ($icon) 
                    <img src="{{ $icon->temporaryUrl() }}" style="max-width: 400px; margin-top: 20px">
                @elseif($iconUrl)
                    <img src="{{ asset($iconUrl) }}" style="max-width: 400px; margin-top: 20px">
                @endif                  
            </div>         

        </div>  
        
        <div class="col-auto ms-auto d-print-none w-full flex justify-end">
            <div class="btn-list">
              <button type="submit" class="btn btn-primary d-sm-inline-block">
                <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-device-floppy" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2" /><path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M14 4l0 4l-6 0l0 -4" /></svg>
                {{ __('Save') }}
              </button>
            </div>
          </div>           
    </div>
</form>