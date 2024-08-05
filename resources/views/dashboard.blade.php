@php
    use App\Models\User;
    $user = null;

    try {
        $user = User::first();
    } catch (Throwable $th) {
        Log::info($th);
    }
@endphp

<x-admin-layout>
    <div class="card card-md">
        <div class="card-stamp card-stamp-lg">
          <div class="card-stamp-icon bg-primary">
            <!-- Download SVG icon from http://tabler-icons.io/i/ghost -->
            <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-confetti" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M4 5h2" /><path d="M5 4v2" /><path d="M11.5 4l-.5 2" /><path d="M18 5h2" /><path d="M19 4v2" /><path d="M15 9l-1 1" /><path d="M18 13l2 -.5" /><path d="M18 19h2" /><path d="M19 18v2" /><path d="M14 16.518l-6.518 -6.518l-4.39 9.58a1 1 0 0 0 1.329 1.329l9.579 -4.39z" /></svg>
          </div>
        </div>
        <div class="card-body">
          <div class="row align-items-center">
            <div class="col-10">
              <h3 class="h1">{{ __('Welcome!', ['name' => $user->name]) }}</span> 👋</h3>
              <div class="markdown text-muted">
                {{ __('This is the configuration panel to manage your application where you can configure your web page.') }}
              </div>
              <div class="mt-3">
                <a href="{{ route('home') }}" class="btn btn-primary" target="_blank" rel="noopener">
                    <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-external-link" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 6h-6a2 2 0 0 0 -2 2v10a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-6" /><path d="M11 13l9 -9" /><path d="M15 4h5v5" /></svg>                    
                    {{ __('Home Page') }}
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>    
</x-admin-layout>
