@push('header-libs')
    <style>
      .clipboard-wrap {
        display: flex;
        /* right: 129px;
        top: 0px; */
        /* width: 55px; */
        /* max-width: min-content; */
        position: absolute;
        align-items: center;  
        height: 100%;    
      }   
      
      .clipboard-wrap > button {
        border-top-left-radius: 5px !important;
        border-bottom-left-radius: 5px !important;
        border-top-right-radius: 5px !important;
        border-bottom-right-radius: 5px !important;
        position: relative !important;
        height: 45px;
        padding: 0px 7px !important;
      }
      
      @media (max-width: 991.98px) {
        .clipboard-wrap {
            top: 1px;
            align-items: flex-start;
            right: 8px;
        }

        .clipboard-wrap > button {
            margin-top: 10px !important;
        }
      }      
    </style>
@endpush

<div 
class="clipboard-wrap" 
x-data="{
clipboard: false,
clipboardHandle: function(e) {
    e.preventDefault();
    this.clipboard = !this.clipboard;
    if (this.clipboard) {
        navigator.clipboard.readText()
        .then((text) => {
            url = text;
            $refs.inputDW.focus();
        })
        .catch((err) => {
            $store.utils.showError(`@php echo Html::htmlEntityDecodeUTF8(__('Error when pasting from clipboard')); @endphp`);
        });                
    } else {
        url = '';
        $refs.inputDW.focus();
    }
},
clear: `<span style='display: flex; items-align: center;'><svg xmlns='http://www.w3.org/2000/svg' class='icon icon-tabler icon-tabler-trash' width='24' height='24' viewBox='0 0 24 24' stroke-width='2' stroke='currentColor' fill='none' stroke-linecap='round' stroke-linejoin='round'><path stroke='none' d='M0 0h24v24H0z' fill='none'/><path d='M4 7l16 0' /><path d='M10 11l0 6' /><path d='M14 11l0 6' /><path d='M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12' /><path d='M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3' /></svg> {{__('Clear') }}</span>`,
paste: `<span style='display: flex; items-align: center;'><svg xmlns='http://www.w3.org/2000/svg' class='icon icon-tabler icon-tabler-clipboard' width='24' height='24' viewBox='0 0 24 24' stroke-width='2' stroke='currentColor' fill='none' stroke-linecap='round' stroke-linejoin='round'><path stroke='none' d='M0 0h24v24H0z' fill='none'/><path d='M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2' /><path d='M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z' /></svg> {{ __('Paste') }}</span>`,
}"}>

    <button class="btn" style="display: block;" @click="clipboardHandle" x-html="clipboard ? clear : paste"></button>
{{-- <button class="btn-ghost" style="display: none;" x-show='clipboard'>{{ __('Clear') }}</button> --}}
</div>