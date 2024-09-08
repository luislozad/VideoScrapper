@props([
    'title' => 'Title',

    'list' => '[]', //key => value

    'openModalDanger' => 'null',
    'onItemUpdate' => 'null',

    'handlerAddItem' => 'null',
    'handlerAddItemCanceled' => 'null',
    'handlerAddItemClose' => 'null',

    'handlerDeleteItem' => 'null',
    'handlerDeleteItemCanceled' => 'null',
    'handlerDeleteItemClose' => 'null',

    'handlerDeleteAll' => 'null',
    'handlerDeleteAllCanceled' => 'null',
    'handlerDeleteAllClose' => 'null',

    'handlerSortItems' => 'null',
])

<div class="table-responsive">
    <label>{{ $title }}</label>
    <div class="mt-3">
        <button type="button" class="btn btn-sm" @click="{{$list}} !== [] && {{$handlerAddItem}} !== null ? {{$handlerAddItem}}('{{$list}}') : null">
            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-plus"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>                
            {{ __('Add') }}
        </button>
        <button type="button" class="btn btn-sm" data-bs-toggle="modal" data-bs-target="#{{\App\Utils\Str::convertToCamelCase($title)}}-1">
            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-trash"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
            {{ __('Delete all') }}
        </button>
        <x-pg-media-downloader::api-service-manager.tabs.parts.modal-danger handlerDelete="{{$list}} !== [] && {{$handlerDeleteAll}} !== null ? {{$handlerDeleteAll}}('{{$list}}') : null" :handlerCancel="$handlerDeleteAllCanceled" :handlerClose="$handlerDeleteAllClose" id="{{\App\Utils\Str::convertToCamelCase($title)}}-1" />        
    </div>
    <table class="table table-responsive mt-1">
        <thead>
          <tr>
            <th>#</th>
            <th class="text-nowrap">Key</th>
            <th class="text-nowrap">Value</th>
            <th></th>
          </tr>
        </thead>
        <tbody x-sort="{{$handlerSortItems}} !== null ? (item, pos) => {{$handlerSortItems}}(item, pos, '{{$list}}') : null">
            <x-pg-media-downloader::api-service-manager.tabs.parts.item :list="$list" :onItemUpdate="$onItemUpdate" :openModalDanger="$openModalDanger" id="{{\App\Utils\Str::convertToCamelCase($title)}}-2" />
            <x-pg-media-downloader::api-service-manager.tabs.parts.modal-danger :handlerDelete="$handlerDeleteItem" :handlerCancel="$handlerDeleteItemCanceled" :handlerClose="$handlerAddItemClose" id="{{\App\Utils\Str::convertToCamelCase($title)}}-2" />
        </tbody>
    </table>
      
</div>