@if (!empty($default) || !empty($custom))
<div class="grid-dropdown-actions dropdown">
    <a href="#" class="btn btn-sm btn-icon dropdown-toggle hide-arrow" data-bs-toggle="dropdown">
        <i class="bx bx-dots-vertical-rounded"></i>
    </a>
    <ul class="dropdown-menu dropdown-menu-end m-0">

        @foreach($default as $action)
            <li class="dropdown-item">{!! Dcat\Admin\Support\Helper::render($action) !!}</li>
        @endforeach

        @if(!empty($custom))

            @if(!empty($default))
                <li class="dropdown-divider"></li>
            @endif

            @foreach($custom as $action)
                <li class="dropdown-item">{!! $action !!}</li>
            @endforeach
        @endif
    </ul>
</div>
@endif
