@props(['errors'])

@if (isset($errors) && $errors->any())
<div id="alert-additional-content-2" class="max-w-3xl p-4 mb-4 text-red-800 border border-red-300 rounded-lg bg-red-50" role="alert">
    <div class="flex items-center">
      <svg class="flex-shrink-0 w-4 h-4 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
        <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
      </svg>
      <span class="sr-only">Info</span>
      <h3 class="text-lg font-medium">Errors</h3>
    </div>
    <div class="mt-2 mb-4 text-sm">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
</div>            
@endif  