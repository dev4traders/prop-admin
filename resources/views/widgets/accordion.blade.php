<div class="accordion mt-3" {!! $attributes !!}>
    @foreach($items as $key => $item)

    <div class="card accordion-item">
        <h2 class="accordion-header d-flex align-items-center">
        <button type="button" class="accordion-button collapsed" data-bs-toggle="collapse" data-bs-target="#accordion{{ $id.$key }}" aria-expanded="false">
            @if(isset($item['icon']))
            <i class="{{ $item['icon'] }} me-2"></i>
            @endif
            {{ $item['title'] }}
        </button>
        </h2>
        <div id="accordion{{ $id.$key }}" class="accordion-collapse collapse {{ $item['collapsed'] == true ? 'show' : '' }}" style="">
        <div class="accordion-body">
            {!! $item['content'] !!}
        </div>
        </div>
    </div>

    @endforeach

</div>
