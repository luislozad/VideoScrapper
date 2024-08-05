<x-admin.navbar-nav>
    <x-admin.profile >
      <a href="{{ route('admin.profile') }}" class="dropdown-item">{{ __('Profile') }}</a>
      <div class="dropdown-divider"></div>
      <form method="POST" action="{{ route('logout') }}">
          @csrf
          <button type="submit" class="dropdown-item" >{{ __('Log Out') }}</button>                
      </form>        
    </x-admin.profile>
  </x-admin.navbar-nav>