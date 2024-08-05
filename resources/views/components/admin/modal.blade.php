@props(['title', 'id', 'modalType'])

<div class="modal modal-blur fade" id="{{ $id }}" tabindex="-1" style="display: none;" aria-hidden="true" wire:ignore>
    <div class="modal-dialog {{ $modalType === 'full' ? 'modal-full-width' : 'modal-lg' }} modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">{{ $title }}</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" @click="modalClose('{{ $id }}')"></button>
        </div>
        <div class="modal-body">
            {{ $slot }}
        </div>
        <div class="modal-footer">
          <a href="#" class="btn btn-link link-secondary" data-bs-dismiss="modal" @click="modalCancel('{{ $id }}')">
            {{ __('Cancel') }}
          </a>
          <a href="#" class="btn btn-primary ms-auto" data-bs-dismiss="modal" @click="modalSave('{{ $id }}')">
            <!-- Download SVG icon from http://tabler-icons.io/i/plus -->
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-device-floppy" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M6 4h10l4 4v10a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12a2 2 0 0 1 2 -2" /><path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" /><path d="M14 4l0 4l-6 0l0 -4" /></svg>
            {{ __('Save') }}
          </a>
        </div>
      </div>
    </div>
  </div>