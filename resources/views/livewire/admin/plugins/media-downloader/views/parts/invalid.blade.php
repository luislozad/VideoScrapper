@props([
    'show' => 'false',
    'errHighlight' => 'false',
])

<div 
class="invalid-feedback animate__animated" 
x-show="{{$show}}" 
:class="{{$errHighlight}} ? 'animate__shakeX' : null"
x-on:animationend="({ animationName }) => {
    if (animationName === 'shakeX' && {{$errHighlight}}) {
        {{$errHighlight}} = false;
    }
}"
x-transition>
{{$slot}}
</div>