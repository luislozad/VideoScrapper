@php
    $modalID = 'addAPIModal';
    $modalTitle = 'Add API';
@endphp

<div id="tab-top-1" class="card tab-pane active show">
    <div class="card-body">
        <x-pg-media-downloader::views.parts.add-btn 
        :label="$modalTitle" 
        handlerModal="handlerOpenModal" 
        :modalID="$modalID" />

        <x-pg-media-downloader::views.parts.modal 
        :id="$modalID" 
        :title="$modalTitle" 
        label="btnTextApiModal" 
        handlerCancel="handlerBtnCancelModal" 
        handlerSave="handlerBtnSaveModal"
        btnSaveStatus="btnAPIStatus">
            <div>
                <x-pg-media-downloader::views.apis.parts.steps
                currStep="apiStatus"
                steps="[
                    { view: 'next', id: getID.rnd() },
                    { view: 'save', id: getID.rnd() },
                ]"
                handlerClick="handlerClickStep"
                />

                <div class="mt-5">
                    <x-pg-media-downloader::views.parts.alert
                    text="warningMsg"
                    btnPrimaryText="warningBtnPrimaryText"
                    show="warningShow"
                    handlerClose="warningClose"
                    handlerBtnPrimary="warningAccept"
                    handlerBtnSecondary="warningCancel"
                    />

                    <template x-if="apiStatus === 'next'">
                        <x-pg-media-downloader::views.apis.steps.step1 />
                    </template>

                    <template x-if="apiStatus === 'save'">                    
                        <x-pg-media-downloader::views.apis.steps.step2 />
                    </template>                    
                </div>

            </div>
            <x-slot:iconBtn>
                <span>
                    <template x-if="apiStatus === 'next'">
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-chevrons-right"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M7 7l5 5l-5 5" /><path d="M13 7l5 5l-5 5" /></svg>
                    </template>
    
                    <template x-if="apiStatus === 'save'">
                        <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-device-floppy"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2" /><path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M14 4l0 4l-6 0l0 -4" /></svg>
                    </template>
                </span>
            </x-slot>
        </x-pg-media-downloader::views.parts.modal>
        
        <div class="container" style="margin-top: 20px;">
            <x-pg-media-downloader::views.apis.table />
        </div>
    </div>
</div>