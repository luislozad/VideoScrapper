<div class="card" x-data="{
    data: Object.assign({
        twitter: '',
        facebook: '',
        instagram: '',
        tiktok: '',
        youtube: '',
    }, {{ Js::from($data) }}),
    save: async function() {
        this.saving = true;
        await $wire.save(this.data);
        this.saving = false;
    },
    saving: false,
}">

    <div class="card-header">
        <h4 class="card-title">{{ __('Social Media') }}</h4>
    </div>
    
    <div class="card-body">
        <x-errors :errors="$errors" /> 

        <div class="mb-3 w-full">
            <label class="form-label">Twitter</label>
            <input type="text" class="form-control" x-model="data.twitter">
        </div>  
        
        <div class="mb-3 w-full">
            <label class="form-label">Facebook</label>
            <input type="text" class="form-control" x-model="data.facebook">
        </div> 

        <div class="mb-3 w-full">
            <label class="form-label">Instagram</label>
            <input type="text" class="form-control" x-model="data.instagram">
        </div>
        
        <div class="mb-3 w-full">
            <label class="form-label">Tiktok</label>
            <input type="text" class="form-control" x-model="data.tiktok">
        </div>            
        
        <div class="mb-3 w-full">
            <label class="form-label">Youtube</label>
            <input type="text" class="form-control" x-model="data.youtube">
        </div> 
        
        <div class="col-auto ms-auto d-print-none w-full flex justify-end">
            <div class="btn-list">
              <button class="btn btn-primary d-sm-inline-block" @click="save()" :disabled="saving">
                <div class="spinner-border spinner-border-sm" role="status" style="display: none;" x-show="saving"></div>
                <svg x-show="!saving" xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-device-floppy" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2" /><path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M14 4l0 4l-6 0l0 -4" /></svg>
                {{ __('Save') }}
              </button>
            </div>
          </div>          
    </div>    
</div>
