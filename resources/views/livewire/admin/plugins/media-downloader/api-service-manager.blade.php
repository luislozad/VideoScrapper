<div>
    <div class="mb-2">
        <label class="form-label">{{ __('Request URL') }}</label>
        <div class="input-group input-group-flat">
            <span class="input-group-text p-0">
                <select class="form-select m-0 py-3 border-0 shadow-none btn btn-ghost-secondary" role="button" style="padding-right: 1.7rem; border-radius: inherit;">
                    <option value="1">GET</option>
                    <option value="2">POST</option>
                </select>            
            </span>
            <input type="text" class="form-control py-3" placeholder="https://server.rapidapi.com/v1/youtube?id=xxxx" />
            <span class="input-group-text">
                <button class="btn btn-primary">{{ __('Send') }}</button>
            </span>
        </div>
    </div>

    <div class="mb-3">
        <div class="form-selectgroup">
          <label class="form-selectgroup-item">
            <input type="radio" name="icons" value="params" class="form-selectgroup-input" checked />
            <span class="form-selectgroup-label">{{ __('Params') }}</span>
          </label>
          <label class="form-selectgroup-item">
            <input type="radio" name="icons" value="headers" class="form-selectgroup-input" />
            <span class="form-selectgroup-label">{{ __('Headers') }}</span>
          </label>
          <label class="form-selectgroup-item">
            <input type="radio" name="icons" value="json" class="form-selectgroup-input" />
            <span class="form-selectgroup-label">{{ __('Body') }}</span>
          </label>
        </div>
    </div>
      
    <div class="table-responsive">
        <label>Query Params</label>
        <div class="mt-2">
            <button type="button" class="btn btn-sm">
                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-plus"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 5l0 14" /><path d="M5 12l14 0" /></svg>                
                {{ __('Add') }}
            </button>
            <button type="button" class="btn btn-sm">
                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-trash"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>
                {{ __('Delete all') }}
            </button>
        </div>
        <table class="table table-responsive mt-1">
            <thead>
              <tr>
                <th>#</th>
                <th class="text-nowrap">Heading 1</th>
                <th class="text-nowrap">Heading 2</th>
                <th class="text-nowrap">Heading 3</th>
                <th class="text-nowrap">Heading 4</th>
                <th class="text-nowrap">Heading 5</th>
                <th class="text-nowrap">Heading 6</th>
                <th class="text-nowrap">Heading 7</th>
                <th class="text-nowrap">Heading 8</th>
                <th class="text-nowrap">Heading 9</th>
                <th class="text-nowrap">Heading 10</th>
              </tr>
            </thead>
            <tbody>
              <tr>
                <th><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-grip-vertical"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /><path d="M9 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /><path d="M9 19m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /><path d="M15 5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /><path d="M15 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /><path d="M15 19m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /></svg></th>
                <td>Cell</td>
                <td>Cell</td>
                <td>Cell</td>
                <td>Cell</td>
                <td>Cell</td>
                <td>Cell</td>
                <td>Cell</td>
                <td>Cell</td>
                <td>Cell</td>
                <td>Cell</td>
              </tr>
              <tr>
                <th><svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-grip-vertical"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M9 5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /><path d="M9 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /><path d="M9 19m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /><path d="M15 5m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /><path d="M15 12m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /><path d="M15 19m-1 0a1 1 0 1 0 2 0a1 1 0 1 0 -2 0" /></svg></th>
                <td>Cell</td>
                <td>Cell</td>
                <td>Cell</td>
                <td>Cell</td>
                <td>Cell</td>
                <td>Cell</td>
                <td>Cell</td>
                <td>Cell</td>
                <td>Cell</td>
                <td>Cell</td>
              </tr>
            </tbody>
        </table>
          
    </div>
            
</div>
  
