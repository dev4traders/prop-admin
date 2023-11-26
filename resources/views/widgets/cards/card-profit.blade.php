<div class="card">
    <div class="card-body">
        <div class="card-title d-flex align-items-start justify-content-between">
            <div class="avatar flex-shrink-0">
                <a href="{{ $link }}" class="avatar-initial rounded bg-label-info"><i class="{{ $icon }}"></i></a>
            </div>
            <div>{!! $toolButton !!}</div>
        </div>
        <span class="fw-semibold d-block mb-1">{{ $title }}</span>
        <h3 class="card-title mb-2">{{ $value }}</h3>
        @if($growing)
            <small class="text-success fw-semibold"><i class="bx bx-up-arrow-alt"></i> {{ $subtitle }}</small>
        @else
            <small class="text-danger fw-semibold"><i class="bx bx-down-arrow-alt"></i> {{ $subtitle }}</small>
        @endif
    </div>
</div>
