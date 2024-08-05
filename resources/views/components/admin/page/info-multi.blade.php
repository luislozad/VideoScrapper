@props(['lang', 'active'])

<div style="display: {{ $active ? 'block' : 'none' }};" x-show="languageCurrent === '{{ $lang }}'">
    <div class="mb-3 w-full">
        <label class="form-label">{{ __('Page title') }}</label>
        <input type="text" class="form-control" placeholder="{{ __('Web page title') }}" x-model="lang.{{ $lang }}.title">
    </div>     
    
    <div class="mb-3 w-full">
        <label class="form-label">{{ __('Site Description (SEO)') }}</label>
        <input type="text" class="form-control" placeholder="{{ __('Website description in the metadata') }}" x-model="lang.{{ $lang }}.description">
    </div> 
    
    <div class="mb-3 w-full">
        <label class="form-label">{{ __('Keywords (SEO)') }}</label>
        <input type="text" class="form-control" placeholder="{{ __('Keywords must be separated by commas') }}" x-model="lang.{{ $lang }}.keywords">
    </div>  
</div>