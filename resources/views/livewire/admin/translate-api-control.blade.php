<div>
    <div class="card">
        <x-errors :errors="$errors" /> 
    
        <div class="card-header">
            <h4 class="card-title">{{ __('Google Cloud Translation API') }}</h4>
        </div>
    
        <div class="card-body card">
            <form wire:submit="save">
                <div class="mb-3 flex space-x-1">
                    <div class="mb-3 w-full">
                        <label class="form-label">{{ __('API Key') }}</label>
                        <input type="text" class="form-control" placeholder="XxxXxxxXxxXXXXXxxXxxxXXXXXXXXxxxXX" wire:model="key" autofocus>
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
            </form>
        </div> 

    </div>
</div>