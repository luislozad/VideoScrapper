<div class="card">

    <div class="card-header">
        <h4 class="card-title">{{ __('Profile Settings') }}</h4>
    </div>    

    <div class="card-body">
        <form wire:submit="save">
            <div class="flex flex-wrap">
        
                <x-errors :errors="$errors" />  
        
                <div class="mb-3 w-full">
                    <label class="form-label">{{ __('Username') }}</label>
                    <input type="text" class="form-control" placeholder="username" wire:model="username" autofocus>
                </div>
        
                <div class="mb-3 w-full">
                    <label class="form-label">{{ __('Old Password') }}</label>
                    <input type="password" class="form-control" placeholder="old password" wire:model="oldPassword">
                </div> 
        
                <div class="mb-3 w-full">
                    <label class="form-label">{{ __('New Password') }}</label>
                    <input type="password" class="form-control" placeholder="new password" wire:model="newPassword">
                </div>           
                
                <div class="mb-3 w-full">
                    <label class="form-label">{{ __('Email') }}</label>
                    <input type="email" class="form-control" placeholder="e.g. user@site.com" wire:model="email">
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
    </div>
</div>
