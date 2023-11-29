<div class="card bg-{{ $class}}">
    @if ($title || $tool)
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="card-title">{!! $title !!}</h5>
            @if ($tool)
                {!! $tool !!}
            @endif
        </div>
    @endif
    <div class="card-body">
        {!! $content !!}
    </div>
    @if($footer)
    <div class="card-footer">
        {!! $footer !!}
    </div>
    @endif
</div>
