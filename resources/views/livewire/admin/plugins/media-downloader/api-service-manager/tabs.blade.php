<div class="mb-3">
    <div class="form-selectgroup">
      <label class="form-selectgroup-item">
        <input type="radio" name="tabs" value="params" class="form-selectgroup-input" checked @click="view = $event.target.value" />
        <span class="form-selectgroup-label">{{ __('Params') }}</span>
      </label>
      <label class="form-selectgroup-item">
        <input type="radio" name="tabs" value="headers" class="form-selectgroup-input" @click="view = $event.target.value" />
        <span class="form-selectgroup-label">{{ __('Headers') }}</span>
      </label>
      <label class="form-selectgroup-item">
        <input type="radio" name="tabs" value="body" class="form-selectgroup-input" @click="view = $event.target.value" />
        <span class="form-selectgroup-label">{{ __('Body') }}</span>
      </label>
    </div>
</div>