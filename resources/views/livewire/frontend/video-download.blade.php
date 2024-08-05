@php
// use Barryvdh\Debugbar\Facades\Debugbar as Logg;

    $files = [];

    if ($json && $json['code'] === 0) {
        $fileJSON = $json['file'];
        $type = $fileJSON['type'];
        $url = $fileJSON['url'];

        for ($i=0; $i < count($type); $i++) { 
            $data = [
                'type' => $type[$i],
                'url' => $url[$i]
            ];

            $files[] = $data;
        }
    }
@endphp

@push('header-libs')
    <style>
        .inputDW {
            outline: 1px solid #4104cf49;
        }

        .inputDW:focus {
            outline: 1px solid #4204cf;
        }
    </style>
@endpush

<div x-data="{
    input: true,
    loading: false,
    download: false,
    error: false,
    url: '',
    getData: async function() {
        if (inputDW.value === '') {
            $store.utils.showError(`@php echo Html::htmlEntityDecodeUTF8(__('The url is not valid!')); @endphp`);
            return;
        }

        this.input = false;
        this.loading = true;
        const res = await $wire.download(this.url);
        
        if (res.success) {
            this.loading = false;
            this.download = true;
        } else {
            this.input = true;
            this.loading = false;
            this.download = false;
            this.error = true;
            $store.utils.showError(`@php echo Html::htmlEntityDecodeUTF8(__('The url is not valid!')); @endphp`);
        }
    },
    rest: async function() {
        this.input = true;
        this.loading = false;
        this.download = false; 
        await $wire.resetChild();
        inputDW.focus();
    }
}"
>
    <div class="subscription-form mt-5" x-show="input" style="position: relative;">
        @csrf
        <div class="form-group">
            <label>{{ __('Link') }}</label>
            <input x-ref="inputDW" id="inputDW" type="text" placeholder="@php echo Html::htmlEntityDecodeUTF8(__('e.g. tiktok.com/@user/video/837377')); @endphp" autofocus autocomplete="off" class="form-control inputDW" x-model="url"> 

            <x-frontend.clipboard />
    
            <button id="btnDownload" type="button" class="btn btn-primary" @click="getData()">
                {{ __('Download Now') }}
            </button>
        
        </div>
    </div>
    
    <div  style="display: none; height: 64px" :style="loading ? { display: 'block' } : { display: 'none' }" class="ssc-head-line"></div>
    
    <div style="display: none;" :style="download ? { display: 'flex' } : { display: 'none' }">

    @if ($videoInfo && $json)
    
        <x-frontend.video-info 
            :image="$json['cover']" 
            :title="$json['title']" 
            :play="$play"
            :files="$files" />      
    @endif
    
    </div> 

</div>

@push('footer-libs')
<script>
    document.addEventListener('alpine:init', () => {
        Alpine.store('utils', {
            showError: function(msg) {
                const notyf = new Notyf({
                    duration: 2000,
                    position: {
                        x: 'center',
                        y: 'top',
                    },
                    dismissible: true,           
                });

                notyf.error(msg);
            }
        });
    });
</script>
@endpush

