@props([
    'currStep' => 'null',
    'steps' => '[]', // { view, id }
    'handlerClick' => 'null',
])

<div class="steps steps-counter steps-lime">
    <template x-for="step in {{$steps}}" :key="step.id">
        <a href="#" :class="{{$currStep}} === step.view ? 'step-item active' : 'step-item'" @click="{{$handlerClick}} ? {{$handlerClick}}(step.view) : null"></a>
    </template>
</div>
  