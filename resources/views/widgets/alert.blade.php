<div class="alert alert-{{ $class }} {{ $dismissable ? 'alert-dismissible' : ''}} " role="alert">
    @if(! empty($icon))<span class="badge badge-center rounded-pill p-3 me-2"><i class="{{ $icon }}"></i></span>@endif
    <div class="d-flex flex-column ps-1">
        <h6 class="alert-heading d-flex align-items-center mb-1">{!! $title !!}</h6>
        <span>{!! $content !!}</span>
    </div>
    @if($dismissable)
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    @endif
</div>
