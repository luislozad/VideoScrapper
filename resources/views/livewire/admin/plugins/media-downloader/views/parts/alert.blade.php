@props([
    'title' => 'Warning',
    'text' => null,
    'btnPrimaryText' => __('Accept'),
    'btnSecondaryText' => __('Cancel'),
    'show' => 'false',
    'displayDefault' => 'none',
    'handlerClose' => 'null',
    'handlerBtnPrimary' => 'null',
    'handlerBtnSecondary' => 'null',
])

@if ($text)
<div 
class="alert alert-warning alert-dismissible" 
role="alert" 
x-transition 
x-show="{{$show}}" 
style="display: {{$displayDefault}};">
    <h3 class="mb-1">{{ $title }}</h3>
    <p x-text="{{$text}}"></p>
    <div class="btn-list">
        <a href="#" class="btn btn-warning" x-text="{{$btnPrimaryText}}" @click="{{$handlerBtnPrimary}}"></a>
        <a href="#" class="btn" @click="{{$handlerBtnSecondary}}">{{ $btnSecondaryText }}</a>
    </div>
</div>
@endif