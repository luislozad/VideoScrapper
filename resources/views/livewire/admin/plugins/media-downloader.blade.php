@push('head-libs')
    <style>
        .editor {
            width: 100%;
            min-height: 165px;
            border: 1px solid #ddd;
        }
        #controls {
            margin: 10px;
        }        
    </style>
@endpush

@push('head-libs')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" integrity="sha512-c42qTSw/wPZ3/5LBzD+Bw5f7bSF2oxou6wEb+I/lqeaKV5FDIfMvvRp772y4jcJLKuGUOpbJMdg/BTl50fJYAw==" crossorigin="anonymous" referrerpolicy="no-referrer" />   
@endpush

@push('head-libs')
    <script defer src="https://cdn.jsdelivr.net/npm/@alpinejs/sort@3.x.x/dist/cdn.min.js"></script>
@endpush

@push('head-libs')
<script src="https://cdnjs.cloudflare.com/ajax/libs/ace/1.4.14/ace.js"></script>    
@endpush

@push('head-libs')
<script src="{{ asset('custom/multiselect-dropdown.js?v=22') }}"></script>
@endpush

@push('head-libs')
<style>
    .disabled-editor {
        opacity: 0.5; /* Hace que el div se vea más claro */
        pointer-events: none; /* Desactiva los eventos de usuario */
        cursor: not-allowed; /* Cambia el cursor a uno que indique que está deshabilitado */
        background-color: #f0f0f0; /* Cambia el fondo a un color gris claro */
    }
</style>
@endpush

@push('head-libs')
<style>
    /* Estilos personalizados para los números de línea */
    .ace_editor .ace_gutter {
        background: #f3f3f3;
        color: #888888;
        font-family: 'Consolas', 'Monaco', 'Courier New', monospace;
        font-size: 13px;
    }

    .ace_editor .ace_gutter-cell {
        padding-left: 10px;
    }

    .ace_editor .ace_gutter-active-line {
        background-color: #e0e0e0;
    }

    .invalid-feedback {
        display: block;
    }
</style>

@endpush

<div x-data="{

    apiStatus: 'next',

    btnTextApiModal: 'Next',
  
    btnAPIStatus: true,

    loadNext: false,

    warningMsg: '',

    showInvalidTitleMsg: false,

    showPlatformSelErr: false,

    warningBtnPrimaryText: 'Confirm',

    titleNewApi: '',
    
    warningShow: false,

    errHighlight: false,
    
    getID: new ShortUniqueId({ length: 10 }),
    
    selectedPlatforms: [],

    step1Options: [
        { text: 'Youtube', value: 'yt', managedBy: null, id: 1 },
        { text: 'Facebook', value: 'fb', managedBy: null, id: 2 },
        { text: 'Twitter', value: 'tw', managedBy: null, id: 3 },
        { text: 'Instagram', value: 'ig', managedBy: null, id: 4 },
        { text: 'Tiktok', value: 'tk', managedBy: 'RapidApi', id: 5 },
        { text: 'Onlyfans', value: 'of', managedBy: null, id: 6 },
        { text: 'Telegram', value: 'tg', managedBy: 'Stronger', id: 7 },
    ],

    warningClose() {
        
    },

    warningAccept() {
        const selectedPlatforms = JSON.parse(JSON.stringify(this.selectedPlatforms));

        selectedPlatforms
        .forEach((p) => {
            if (p.managedBy !== null) {
                p.confirm = true;
            }
        });

        this.selectedPlatforms = selectedPlatforms;
        this.warningShow = false;
    },

    warningCancel() {
        this.warningShow = false;
    },

    watchInputsStep1() {
        this.$watch('titleNewApi', () => {
            this.validateTitleStep1();
        });

        this.$watch('selectedPlatforms', () => {
            this.validatePlatformsStep1();            
        });
    },
    
    init() {
        document.addEventListener('eOnStep1PlatformOptionClick', ({ detail }) => {
            this.onStep1PlatformOptionClick(detail);
        });
        
        this.watchInputsStep1();
    },

    addPlatformById(id) {
        const platform = this.step1Options.find(p => p.id === id);
        
        if (!platform) {
            console.error(`Platform with ID ${id} not found in predefined platforms.`);
            return;
        }
        
        // Verifica si el objeto ya está en selectedPlatforms
        const exists = this.selectedPlatforms.some(p => p.id === id);

        const selectedPlatforms = JSON.parse(JSON.stringify(this.selectedPlatforms));
        
        if (!exists) {
            selectedPlatforms.push(platform);
        }

        this.selectedPlatforms = selectedPlatforms;
    },

    removePlatformById(id) {
        // Encuentra el índice del objeto en selectedPlatforms
        const index = this.selectedPlatforms.findIndex(p => p.id === id);

        const selectedPlatforms = JSON.parse(JSON.stringify(this.selectedPlatforms));
        
        if (index !== -1) {
            selectedPlatforms.splice(index, 1);
        }
        
        this.selectedPlatforms = selectedPlatforms;
    },    

    deleteAllSelectedPlatforms() {
        this.selectedPlatforms = [];
    },

    addAllSelectedPlatforms() {
        const selectedPlatforms = JSON.parse(JSON.stringify(this.selectedPlatforms));

        this
        .step1Options
        .forEach(platform => {
            const exists = this.selectedPlatforms.some(p => p.id === platform.id);
            
            if (!exists) {
                selectedPlatforms.push(JSON.parse(JSON.stringify(platform)));
            }
        });

        this.selectedPlatforms = selectedPlatforms;
    },

    showWarning(platforms) {
        const text = platforms
        .map(({ text }) => text)
        .join(', ');

        if (platforms.length === 1) {
            this.warningMsg = `${text}: ` + '{{ __('This platform is managed by another service. Would you like to transfer control to this new service and disconnect it from the current one?') }}';
            this.warningShow = true;           
        } else if (platforms.length > 1) {
            this.warningMsg = `${text}: ` + '{{ __('These platforms are managed by another service. Would you like to transfer control to this new service and disconnect them from the current one?') }}';               
            this.warningShow = true;
        }
    },

    validateAddedPlatforms() {
        const selectedPlatforms = this.selectedPlatforms;
        
        const managedOpts = selectedPlatforms
        .filter(({ managedBy, confirm }) => managedBy !== null && !confirm);

        if (managedOpts.length > 0) {
            this.showWarning(managedOpts);
            return false;
        } else {
            this.warningShow = false;
            return true;
        }
    },

    safeAddPlatform(dt) {
        const { checked, id, text } = dt;

        if (text === 'All' && checked) {
            this.addAllSelectedPlatforms();
            this.validateAddedPlatforms();
        } else if (text === 'All' && !checked) {
            this.deleteAllSelectedPlatforms();
            this.validateAddedPlatforms();
        } else if (checked) {
            this.addPlatformById(+id);
            this.validateAddedPlatforms();
        } else if (!checked) {
            this.removePlatformById(+id);
            this.validateAddedPlatforms();
        }
    },

    onStep1PlatformOptionClick(dt) {
        this.safeAddPlatform(dt);
    },

    onStep1PlatformChange(e) {

    },

    dispatchErrorHighlight() {
        if ((this.showInvalidTitleMsg || this.showPlatformSelErr) && this.loadNext) {
            this.errHighlight = true;
        }
    },

    validateTitleStep1() {
        const title = this.titleNewApi;

        if (title === '') {
            this.showInvalidTitleMsg = true;
            return false;
        } else {
            this.showInvalidTitleMsg = false;
        }
        
        return true;
    },

    validatePlatformsStep1() {
        const platforms = this.selectedPlatforms;

        if (platforms.length === 0) {
            this.showPlatformSelErr = true;
            return false;
        } else {
            this.showPlatformSelErr = false;
        }

        return true;
    },

    validateStep1Inputs() {
        const validTitle = this.validateTitleStep1();
        const validSelection = this.validatePlatformsStep1();
        
        return validTitle && validSelection;
    },

    onBtnNextApis() {
        const validatedIn = this.validateStep1Inputs();
        this.dispatchErrorHighlight();

        if (validatedIn) {
            /* 
                Verify that none of the platforms are managed by third-party services. 
                If they are, ensure that their control transfer has been confirmed 
            */
            const managedPlatforms = this.validateAddedPlatforms();

            if (managedPlatforms) {
                this.loadNext = false;
                this.apiStatus = 'save';
                this. btnTextApiModal = '{{ __('Save') }}';

                return;
            }
        }

        this.loadNext = true;
    },

    handlerClickStep(view) {
        console.log(view);
    },
    
    handlerOpenModal(modalID) {
    
    },
    handlerBtnSaveModal(modalID) {
        if (modalID === 'addAPIModal') {
            this.onBtnNextApis();
        }
    },
    handlerBtnCancelModal(modalID) {
    
    },  
}">
    <div class="card">
        <div class="card-body">
            <h3 class="card-title">{{ __('Media Downloader') }}</h3>
            {{-- @livewire('admin.plugins.media-downloader.api-service-manager') --}}
          {{-- <p class="text-secondary">This is some text within a card body.</p> --}}
            <!-- Cards with tabs component -->
            <div class="card-tabs">
                <!-- Cards navigation -->
                <ul class="nav nav-tabs">
                    <li class="nav-item"><a href="#tab-top-1" class="nav-link active" data-bs-toggle="tab">{{ __('APIs List') }}</a></li>
                    <li class="nav-item"><a href="#tab-top-2" class="nav-link" data-bs-toggle="tab">{{ __('Platforms') }}</a></li>
                </ul>
                <div class="tab-content">
                    <!-- Content of card #1 -->
                    <x-pg-media-downloader::views.apis />
                    <!-- Content of card #2 -->
                    <x-pg-media-downloader::views.platforms />
                </div>
            </div>

          
        </div>
    </div>
</div>

@push('footer-libs')
<script src="https://cdn.jsdelivr.net/npm/short-unique-id@5.2.0/dist/short-unique-id.min.js"></script>    
@endpush