@if($with_card)
<div class="card mx-2 my-2">
@endif
<div class="row px-2 py-2">
    <div class="col-sm-4 d-flex">
        <div class="avatar flex-shrink-0 me-3">
            <span class="avatar-initial rounded bg-label-{{ $class }}">{!! $icon !!}</span>
        </div>
        <h6 class="mt-2">{{ $title }}</h6>
    </div>
    <div class="col-sm-8">
        <span>{{$value_title}}</span>
        {!! $progress !!}
    </div>
</div>
@if($with_card)
</div>
@endif
