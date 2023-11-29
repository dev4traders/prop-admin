@if($title)
    <h6 class="text-muted">{{$title}}</h6>
@endif
<div class="nav-align-top mb-4">
    <ul class="nav {{$button_type===\Dcat\Admin\TabButtonType::TAB ? 'nav-tabs' : 'nav-pills mb-3'}} {{$fill ? 'nav-fill':''}}" role="tablist">
        @foreach($tabs as $id => $tab)
            <li class="nav-item" role="presentation">
                @if(!empty($tab['button']->href))
                <a href="{{ $tab['button']->href }}">
                @endif
                    <button type="button" class="nav-link {{ $id == $active ? 'active' : '' }}" role="tab"
                            data-bs-toggle="tab"
                            data-bs-target="#tab_{{$tab['id']}}"
                            aria-controls="tab_{{$tab['id']}}"
                            aria-selected="{{ $id == $active ? 'true' : '' }}"
                            tabindex="{{ $id == $active ? '0' : '-1' }}">
                        @if($builder)
                            {!! $builder($tab['button']) !!}
                        @else
                            @if($tab['button']->icon)
                                <i class="tf-icons {{$tab['button']->icon}} me-1"></i><span
                                        class="d-none d-sm-block">{{$tab['button']->title}}</span>
                            @else
                                {{$tab['button']->title}}
                            @endif
                            @if($tab['button']->badge)
                                <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-danger ms-1">
                                    {{$tab['button']->badge}}
                                </span>
                            @endif
                        @endif

                    </button>
                @if(!empty($tab['button']->href))
                </a>
                @endif
            </li>
        @endforeach
    </ul>
    <div class="tab-content">
        @foreach($tabs as $id => $tab)
            <div class="tab-pane fade {{ $id == $active ? 'show active' : '' }}" id="tab_{{$tab['id']}}"
                 role="tabpanel">
                 {!! $tab['content'] ?? '' !!}
            </div>
        @endforeach
    </div>
</div>
