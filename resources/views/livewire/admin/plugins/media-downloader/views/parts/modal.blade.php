@props([
    'title' => 'Title Modal',
    'label' => 'null',
    'id' => null,
    'handlerCancel' => 'null',
    'handlerSave' => 'null',
    'btnSaveStatus' => 'false',
])

@if ($id)
<div class="modal" id="{{ $id }}" tabindex="-1">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">{{ $title }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                {{ $slot }}
            </div>
            <div class="modal-footer">
                <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal" @click="{{ $handlerCancel }} ? {{ $handlerCancel }}({{$id}}) : null">
                    {{ __('Cancel') }}
                </a>
                <a href="#" :class="{{$btnSaveStatus}} ? 'btn btn-primary ms-auto' : 'btn btn-primary ms-auto disabled'" @click="{{ $handlerSave }} ? {{ $handlerSave }}('{{$id}}') : null">
                    {{ $iconBtn }}
                    <span x-text="{{$label}} ? {{$label}} : 'Save'"></span>
                </a>
            </div>
        </div>
    </div>
</div>
@endif
