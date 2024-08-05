@props(['title', 'id', 'modalType' => 'lg'])

<div>
    <button type="button" class="bg-transparent border-0 p-0" data-bs-toggle="modal" data-bs-target="#{{ $id }}" @click="modalButtonClick('{{ $id }}')">
        {{ $slot }}
    </button>
    <x-admin.modal :title="$title" :id="$id" :modalType="$modalType">
        {{ $modal }}
    </x-admin.modal>
</div>