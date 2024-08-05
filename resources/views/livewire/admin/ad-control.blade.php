    @php
        $htmlFix = function($text) {
            return Html::htmlEntityDecodeUTF8($text);
        };
    @endphp

    @push('head-libs')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/default.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/styles/base16/dracula.min.css" integrity="sha512-zKpFlhUX8c+WC6H/XTJavnEpWFt2zH9BU9vu0Hry5Y+SEgG21pRMFcecS7DgDXIegXBQ3uK9puwWPP3h6WSR9g==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/highlight.js/11.9.0/highlight.min.js"></script>
    @endpush
    @push('head-libs')
    <script type="module">
        import { CodeJar } from 'https://cdn.jsdelivr.net/npm/codejar@4.2.0/dist/codejar.min.js';
        window.CodeJar = CodeJar;
    </script>
    @endpush
    @push('head-libs')
    <style>
        .editor.hljs {
            padding: 10px;
            border-radius: 5px;
            margin-top: 5px;
        }        
    </style>
    @endpush
    <div class="flex flex-wrap space-x-1" x-data="{
        getElementData: function(key) {
            const checkbox = $refs[`checkbox${key}`];
            const code = $refs[`editor${key}`];
            return {
                checked: checkbox ? checkbox.checked : null,
                code: code ? code.textContent : null,
            };
        },
        saveData: async function(data, key) {
            try {
                const isSave = await $wire[key](data);

                return isSave;
            } catch(err) {
                return false;
            }
        },
        modalButtonClick: function(id) {
        },
        modalClose: function(id) {
        },
        modalCancel: function(id) {
        },
        modalSave: async function(id) {
            if (id === 'modal-home-ads') {
                const homeAdsTop = this.getElementData('HomeAdsTop');
                const homeAdsBottom = this.getElementData('HomeAdsBottom');

                const data = {
                    top: homeAdsTop,
                    bottom: homeAdsBottom,
                };

                const isSave = await this.saveData(data, 'saveHomeAds');
                console.log(isSave, 'saveHomeAds');
            } else if (id === 'modal-download-ads') {
                const downloadAds = this.getElementData('DownloadAdsFlotating');

                const data = downloadAds;

                console.log(data);

                const isSave = await this.saveData(data, 'saveDownloadAds');
                console.log(isSave, 'saveDownloadAds');
            } else if (id === 'modal-scripts') {
                const scriptsHeader = this.getElementData('ScriptsHeader');
                const scriptsFooter = this.getElementData('ScriptsFooter');

                const data = {
                    header: scriptsHeader,
                    footer: scriptsFooter,
                };                

                const isSave = await this.saveData(data, 'saveScripts');
                console.log(isSave, 'saveScripts');
            }
        },
    }">
    {{-- {{ debug($homeAds) }} --}}
        <x-admin.card title="{!! $htmlFix(__('Home Ads')) !!}">
            <x-slot:icon>
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-ad-circle-filled" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 2c5.523 0 10 4.477 10 10s-4.477 10 -10 10c-5.43 0 -9.848 -4.327 -9.996 -9.72l-.004 -.28l.004 -.28c.148 -5.393 4.566 -9.72 9.996 -9.72zm-3.5 6a2.5 2.5 0 0 0 -2.495 2.336l-.005 .164v4.5l.007 .117a1 1 0 0 0 1.986 0l.007 -.117v-1h1v1l.007 .117a1 1 0 0 0 1.986 0l.007 -.117v-4.5l-.005 -.164a2.5 2.5 0 0 0 -2.495 -2.336zm6.5 0h-1a1 1 0 0 0 -1 1v6a1 1 0 0 0 1 1h1a3 3 0 0 0 3 -3v-2a3 3 0 0 0 -3 -3zm0 2a1 1 0 0 1 1 1v2a1 1 0 0 1 -.883 .993l-.117 .007v-4zm-6.5 0a.5 .5 0 0 1 .492 .41l.008 .09v1.5h-1v-1.5l.008 -.09a.5 .5 0 0 1 .492 -.41z" stroke-width="0" fill="currentColor" /></svg>            
            </x-slot>
            <x-admin.button-modal title="{!! $htmlFix(__('Home Ads')) !!}" id="modal-home-ads">
                <x-admin.ads.home-ads />
                <x-slot:modal>
                    <div class="flex flex-wrap space-y-5">
                        <div class="w-full">
                            <label class="row">
                              <span class="col">{{ __('Top Ad') }}</span>
                              <span class="col-auto">
                                <label class="form-check form-check-single form-switch">
                                  <input class="form-check-input" type="checkbox" x-ref="checkboxHomeAdsTop" {{ !$homeAds['error'] ? $homeAds['data']['top']['checked'] ? 'checked' : false  : false }}>
                                </label>
                              </span>
                            </label>
                            <div>
                                <div class="editor language-html" x-ref="editorHomeAdsTop" wire:ignore></div>
                            </div>
                        </div> 
                        <div class="w-full">
                            <label class="row">
                              <span class="col">{{ __('Bottom Ad') }}</span>
                              <span class="col-auto">
                                <label class="form-check form-check-single form-switch">
                                  <input class="form-check-input" type="checkbox" x-ref="checkboxHomeAdsBottom" {{ !$homeAds['error'] ? $homeAds['data']['bottom']['checked'] ? 'checked' : false : false }}>
                                </label>
                              </span>
                            </label>
                            <div>
                                <div class="editor language-html" x-ref="editorHomeAdsBottom"></div>
                            </div>
                        </div>                                              
                    </div>
                </x-slot>           
            </x-admin.button-modal>
        </x-admin.card>

        <x-admin.card title="{{ __('Download Ads') }}">
            <x-slot:icon>
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-ad-circle-filled" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 2c5.523 0 10 4.477 10 10s-4.477 10 -10 10c-5.43 0 -9.848 -4.327 -9.996 -9.72l-.004 -.28l.004 -.28c.148 -5.393 4.566 -9.72 9.996 -9.72zm-3.5 6a2.5 2.5 0 0 0 -2.495 2.336l-.005 .164v4.5l.007 .117a1 1 0 0 0 1.986 0l.007 -.117v-1h1v1l.007 .117a1 1 0 0 0 1.986 0l.007 -.117v-4.5l-.005 -.164a2.5 2.5 0 0 0 -2.495 -2.336zm6.5 0h-1a1 1 0 0 0 -1 1v6a1 1 0 0 0 1 1h1a3 3 0 0 0 3 -3v-2a3 3 0 0 0 -3 -3zm0 2a1 1 0 0 1 1 1v2a1 1 0 0 1 -.883 .993l-.117 .007v-4zm-6.5 0a.5 .5 0 0 1 .492 .41l.008 .09v1.5h-1v-1.5l.008 -.09a.5 .5 0 0 1 .492 -.41z" stroke-width="0" fill="currentColor" /></svg>            
            </x-slot>
            <x-admin.button-modal title="{{ __('Download Ads') }}" id="modal-download-ads">
                <x-admin.ads.download-ads />
                <x-slot:modal>
                    <div class="flex flex-wrap space-y-5">
                        <div class="w-full">
                            <label class="row">
                              <span class="col">{{ __('Floating Ad') }}</span>
                              <span class="col-auto">
                                <label class="form-check form-check-single form-switch">
                                  <input class="form-check-input" type="checkbox" x-ref="checkboxDownloadAdsFlotating" {{ !$downloadAds['error'] ? $downloadAds['data']['checked'] ? 'checked' : false : false }}>
                                </label>
                              </span>
                            </label>
                            <div>
                                <div class="editor language-html" x-ref="editorDownloadAdsFlotating"></div>
                            </div>
                        </div>                                              
                    </div>
                </x-slot>                      
            </x-admin.button-modal>
        </x-admin.card> 
        
        <x-admin.card title="Scripts">
            <x-slot:icon>
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-brand-javascript" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M20 4l-2 14.5l-6 2l-6 -2l-2 -14.5z" /><path d="M7.5 8h3v8l-2 -1" /><path d="M16.5 8h-2.5a.5 .5 0 0 0 -.5 .5v3a.5 .5 0 0 0 .5 .5h1.423a.5 .5 0 0 1 .495 .57l-.418 2.93l-2 .5" /></svg>            
            </x-slot>
            <x-admin.button-modal title="Scripts" id="modal-scripts">
                <x-admin.ads.scripts /> 
                <x-slot:modal>
                    <div class="flex flex-wrap space-y-5">
                        <div class="w-full">
                            <label class="row">
                              <span class="col">{{ __('Header Script') }}</span>
                              <span class="col-auto">
                                <label class="form-check form-check-single form-switch">
                                  <input class="form-check-input" type="checkbox" x-ref="checkboxScriptsHeader" {{ !$scritps['error'] ? $scritps['data']['header']['checked'] ? 'checked' : false : false }}>
                                </label>
                              </span>
                            </label>
                            <div>
                                <div class="editor language-html" x-ref="editorScriptsHeader"></div>
                            </div>
                        </div> 
                        <div class="w-full">
                            <label class="row">
                              <span class="col">{{ __('Footer Script') }}</span>
                              <span class="col-auto">
                                <label class="form-check form-check-single form-switch">
                                  <input class="form-check-input" type="checkbox" x-ref="checkboxScriptsFooter" {{ !$scritps['error'] ? $scritps['data']['footer']['checked'] ? 'checked' : false : false }}>
                                </label>
                              </span>
                            </label>
                            <div>
                                <div class="editor language-html" x-ref="editorScriptsFooter"></div>
                            </div>
                        </div>                                              
                    </div>                    
                </x-slot>                 
            </x-admin.button-modal>
        </x-admin.card>           
    </div>

    @push('footer-libs')
    <script>
        window.addEventListener('DOMContentLoaded', () => {
            const highlight = (editor) => {
                editor.textContent = editor.textContent;
                hljs.highlightBlock(editor);
            };

            const editors = document.querySelectorAll('.editor');

            const defaultData = { checked: false, code: '<!-- Here your code -->' };

            const homeAds = {{ !$homeAds['error'] ? Js::from($homeAds['data']) : 'null' }} || ({ top: defaultData, bottom: defaultData  });
            const downloadAds = {{ !$downloadAds['error'] ? Js::from($downloadAds['data']) : 'null'  }} || defaultData;
            const scritps = {{ !$scritps['error'] ? Js::from($scritps['data']) : 'null'  }} || ({ header: defaultData, footer: defaultData });

            if (editors.length > 0) {
                editors.forEach((editor) => {
                    const jar = new CodeJar(editor, highlight);        
                    
                    const key = editor.attributes.getNamedItem('x-ref').value;
                    
                    if (key === 'editorHomeAdsTop') {
                        jar.updateCode(homeAds['top']['code']);
                    } else if (key === 'editorHomeAdsBottom') {
                        jar.updateCode(homeAds['bottom']['code']);
                    } else if (key === 'editorDownloadAdsFlotating') {
                        jar.updateCode(downloadAds['code']);
                    } else if (key === 'editorScriptsHeader') {
                        jar.updateCode(scritps['header']['code']);
                    } else if (key === 'editorScriptsFooter') {
                        jar.updateCode(scritps['footer']['code']);
                    }
                });
            }         
        });   
    </script>          
    @endpush