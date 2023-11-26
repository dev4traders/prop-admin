@if($hasDivider)
<li>
    <div class="dropdown-divider"></div>
</li>
@endif
<li>
    <a class="dropdown-item" href="{{ $url }}">
        <span class="d-flex align-items-center align-middle">
            <i class="flex-shrink-0 {{ $icon }} me-2"></i>
            <span class="flex-grow-1 align-middle">{{ $title }}</span>
            @if(!is_null($badge))
            <span class="flex-shrink-0 badge badge-center rounded-pill {{ $badge->class }} w-px-20 h-px-20">{{ $badge->value }}</span>
            @endif
        </span>
    </a>
</li>
