<div class="mb-2">
    <label class="form-label">{{ __('Request URL') }}</label>
    <div class="input-group input-group-flat">
        <span class="input-group-text p-0">
            <select class="form-select m-0 py-3 border-0 shadow-none btn btn-ghost-secondary" role="button" style="padding-right: 1.7rem; border-radius: inherit;">
                <option value="1">GET</option>
                <option value="2">POST</option>
            </select>            
        </span>
        <input type="text" class="form-control py-3" placeholder="https://server.rapidapi.com/v1/youtube?id=xxxx" @input="handlerInputUrl" x-model="url" />
        <span class="input-group-text">
            <button class="btn btn-primary">{{ __('Send') }}</button>
        </span>
    </div>
</div>