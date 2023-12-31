<div {!! $attributes !!}>
    @if ($title || $tools)
        <div class="card-header d-flex align-items-center justify-content-between">
            <h5 class="card-title">{!! $title !!}</h5>
            <div class="box-tools pull-right">
                @foreach($tools as $tool)
                    {!! $tool !!}
                @endforeach
            </div>
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
