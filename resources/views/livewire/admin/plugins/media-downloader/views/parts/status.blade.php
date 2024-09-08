@props([
    'isActive' => 'false'
])

<span :class="{{ $isActive }} ? 'badge bg-green' : 'badge bg-red'" x-text="{{ $isActive }} ? '{{ __('Enabled') }}' : '{{ __('Disabled') }}'">
</span>