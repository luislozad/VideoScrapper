<table class="table table-responsive">
    <thead>
      <tr>
        <th>#</th>
        <th class="text-nowrap">{{ __('Service') }}</th>
        <th class="text-nowrap">{{__('Post Type')  }}</th>
        <th class="text-nowrap">{{__('Patforms')  }}</th>
        <th class="text-nowrap">{{ __('Status') }}</th>
        <th class="text-nowrap">{{ __('Setting') }}</th>
        <th class="text-nowrap">{{ __('Delete') }}</th>
      </tr>
    </thead>
    <tbody>
      <tr>
        <th>1</th>
        <td>Rapidapi</td>
        <td>
            <span class="badge bg-secondary">Multi</span>
        </td>
        <td>
            <x-pg-media-downloader::views.apis.platforms />
        </td>
        <td>
            <x-pg-media-downloader::views.parts.status />
        </td>
        <td>
            <div class="btn-a" type="button">
                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-settings"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z" /><path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" /></svg>                                                
            </div>                                            
        </td>
        <td>
            <div class="btn-a" type="button">
                <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-trash"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 7l16 0" /><path d="M10 11l0 6" /><path d="M14 11l0 6" /><path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" /><path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" /></svg>                                                
            </div>
        </td>
      </tr>
    </tbody>
  </table>
                                   
