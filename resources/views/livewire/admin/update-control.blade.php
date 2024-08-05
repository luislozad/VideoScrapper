<div>
    <form class="card" wire:submit="unzip">

        <x-errors :errors="$errors" /> 

        <div class="card-header">
            <h4 class="card-title">{{ __('Update your system') }}</h4>
        </div>

        <div class="card-body card flex items-center">
            <div class="mb-3 flex space-x-1">
                <input type="file" class="form-control" wire:model="file"  accept=".zip" />   
                <button type="submit" class="btn btn-primary d-sm-inline-block">
                    <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-file-upload" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" /><path d="M12 11v6" /><path d="M9.5 13.5l2.5 -2.5l2.5 2.5" /></svg>
                    {{ __('Upload Now') }}
                </button>                            
            </div>           
        </div> 
    </form>
</div>
