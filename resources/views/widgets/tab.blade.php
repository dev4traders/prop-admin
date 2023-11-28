@if($title)
    <h6 class="text-muted">{{$title}}</h6>
@endif
<div class="nav-align-top mb-4">
    <ul class="nav {{$type===\Dcat\Admin\Widgets\Tab::TYPE_TAB ? 'nav-tabs' : 'nav-pills mb-3'}} {{$fill ? 'nav-fill':''}}" role="tablist">
        @foreach($tabs as $tab)
            <li class="nav-item" role="presentation">
                <button type="button" class="nav-link {{$tab['active']? 'active': ''}}" role="tab"
                        data-bs-toggle="tab"
                        data-bs-target="#tab_{{$tab['id']}}"
                        aria-controls="tab_{{$tab['id']}}"
                        aria-selected="{{$tab['active']? 'true': ''}}"
                        tabindex="{{$tab['active']? '0': '-1'}}">
                    @if($tab['icon'])
                        <i class="tf-icons {{$tab['icon']}} me-1"></i><span
                                class="d-none d-sm-block">{{$tab['title']}}</span>
                    @else
                        {{$tab['title']}}
                    @endif
                    @if($tab['badge'])
                        <span class="badge rounded-pill badge-center h-px-20 w-px-20 bg-label-danger ms-1">
                            {{$tab['badge']}}
                        </span>
                    @endif
                </button>
            </li>
        @endforeach
    </ul>
    <div class="tab-content">
        @foreach($tabs as $tab)
            <div class="tab-pane fade {{$tab['active']? 'show active': ''}}" id="tab_{{$tab['id']}}"
                 role="tabpanel">
                {!! $tab['content'] !!}
            </div>
        @endforeach
    </div>
</div>
