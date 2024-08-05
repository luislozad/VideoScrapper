@php
use App\Models\Ads;

$data = ['code' => '', 'checked' => false];

try {
  $ad = Ads::where('type', 'download-ads')->first();

  if ($ad) {
    $data = json_decode($ad->data, true);
  }
} catch (\Throwable $th) {
  Log::info($th);
}
@endphp

@props(['image', 'play', 'title', 'files'])

<div class="row align-items-center testim-inner" x-data="{
  data: {{ Js::from($data) }},
  openPopup: false,
  handlePopup: function() {
    if (!this.openPopup && this.data.checked) {
      Swal.fire({
        html: this.data.code,
        position: 'center',
        showConfirmButton: false,
        showCloseButton: true,
      });
      this.openPopup = true;   
    }
  }
}">

    <!--begin col-md-6 -->
    <div class="col-md-6">

      <!--begin video-popup-wrapper-->
      <div class="video-popup-wrapper margin-right-25">

        <!--begin popup-gallery-->
        <div class="popup-gallery">
          
          <img src="{{ $image }}" id="image-cover" class="width-100 image-shadow video-popup-image responsive-bottom-margins" crossorigin="anonymous">

          <a class="popup4 video-play-icon" href="{{ $play }}">
            <i class="bi bi-caret-right-fill"></i>
          </a>

        </div>
        <!--end popup-gallery-->

      </div>
      <!--end video-popup-wrapper-->
  
    </div>
    <!--end col-md-6 -->    

    <!--begin col-md-6 -->
    <div class="col-md-6">
      
      <h3>{{ $title }}</h3>
      
      @foreach ($files as $file)
      <a 
      @click="handlePopup()"
      target="_blank"
      href="{{ $file['url'] }}" 
      {{-- href="#"  --}}
      class="scrool btn btn-lg btn-primary"
      style="margin-bottom: 10px"
      >
      {{ __('Download') }} {{ $file['type'] }}
    </a>  
    @endforeach
    
    <a 
      type="button" 
      class="btn btn-lg btn-ghost" 
      style="margin-bottom: 15px; margin-top: 15px; width: 100%;"
      {{-- wire:click="goBack" --}}
      @click="rest()"
    >
      {{ __('GO BACK') }}
    </a>

    </div>
    <!--end col-md-5 -->
  </div>