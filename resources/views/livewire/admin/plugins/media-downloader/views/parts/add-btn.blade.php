@props([
    'label' => 'Add',
    'handlerModal' => 'null',
    'modalID' => 'null'
])

<div class="page-header">
    <div class="row align-items-center">
      <div class="col">
      </div>
      <div class="col-auto ms-auto">
        <div class="btn-list">
          <a href="#" class="btn btn-primary d-none d-sm-inline-block" data-bs-toggle="modal" data-bs-target="#{{$modalID}}" @click="{{$handlerModal}} ? {{$handlerModal}}({{$modalID}}) : null">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
              <line x1="12" y1="5" x2="12" y2="19" />
              <line x1="5" y1="12" x2="19" y2="12" />
            </svg>
            {{ $label }}
          </a>
          <a href="#" class="btn btn-primary d-sm-none btn-icon" data-bs-toggle="modal" data-bs-target="#{{$modalID}}" aria-label="{{$label}}" @click="{{$handlerModal}} ? {{$handlerModal}}({{$modalID}}) : null">
            <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
              <path stroke="none" d="M0 0h24v24H0z" fill="none" />
              <line x1="12" y1="5" x2="12" y2="19" />
              <line x1="5" y1="12" x2="19" y2="12" />
            </svg>
          </a>
        </div>
      </div>
    </div>
</div>