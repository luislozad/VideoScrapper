<div>
    <div>
        <label class="form-check form-check-inline" @click="enableEditor(false)">
            <input class="form-check-input" type="radio" name="radios-inline" checked="">
            <span class="form-check-label">{{ __('None') }}</span>
        </label>
        <label class="form-check form-check-inline" @click="enableEditor(true)">
            <input class="form-check-input" type="radio" name="radios-inline">
            <span class="form-check-label">JSON</span>
        </label>
     </div>    
    <div id="editor" class="editor"></div>
</div>