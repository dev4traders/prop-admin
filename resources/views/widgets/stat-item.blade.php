@if($with_card)
<div class="card mx-2 my-2">
@endif
<div class="d-flex px-2 py-2">
    <div class="avatar flex-shrink-0 me-3">
        <span class="avatar-initial rounded bg-label-primary">{!! $icon !!}</span>
    </div>
    <div class="d-flex w-100 flex-wrap align-items-center justify-content-between gap-2">
        <div class="me-2">
            @if($inverse)
            <small class="d-block mb-1 text-muted">{{ $description }}</small>
            <h6 class="mb-0">{{ $title }}</h6>
            @else
            <h6 class="mb-0">{{ $title }}</h6>
            <small class="text-muted">{{ $description }}</small>
            @endif
        </div>
        @if($value)
        <div class="user-progress">
        <small class="fw-medium">{{ $value }}</small>
        </div>
        @endif
    </div>
</div>
@if($with_card)
</div>
@endif
