@props([
    'label' => 'Title Select',
    'handlerChange' => 'null',
    'handlerClickOption' => 'null',
    'options' => '[]', // { text, value, disabled, id }
])

<div>
    <label class="form-label">{{ $label }}</label>
    <select multiple multiselect-search="true" multiselect-select-all="true" multiselect-max-items="3" x-on:change="{{$handlerChange}}">
        <template x-for="opt in {{$options}}" :key="opt.id">
            <option 
            x-on:click="{{$handlerClickOption}}" 
            :value="opt.id" 
            x-text="opt.text">
        </option>
        </template>
    </select>    
</div>