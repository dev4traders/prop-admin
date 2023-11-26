<li class="nav-item dropdown-shortcuts navbar-dropdown dropdown me-2 me-xl-0">
    <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
    <i class="bx bx-grid-alt bx-sm"></i>
    </a>
    <div class="dropdown-menu dropdown-menu-end py-0">
    <div class="dropdown-menu-header border-bottom">
        <div class="dropdown-header d-flex align-items-center py-3">
        <h5 class="text-body mb-0 me-auto">{{ __('admin.shortcuts') }}</h5>
        @if($canAddShortcut)
        <a href="javascript:void(0)" class="dropdown-shortcuts-add text-body" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="{{ __('admin.add_shortcut') }}" data-bs-original-title="{{ __('admin.add_shortcut') }}"><i class="bx bx-sm bx-plus-circle"></i></a>
        @endif
        </div>
    </div>
    <div class="dropdown-shortcuts-list scrollable-container ps">

        <div class="row row-bordered overflow-visible g-0">
            @foreach($items as $item)
            <div class="dropdown-shortcuts-item col">
                <span class="dropdown-shortcuts-icon bg-label-secondary rounded-circle mb-2">
                <i class="bx bx-{{ $item['icon']}} fs-4"></i>
                </span>
                <a href="{{ $item['url']}}" class="stretched-link">{{ $item['title']}}</a>
                <small class="text-muted mb-0">{{ $item['description']}}</small>
            </div>
            @endforeach
            <div class="ps__rail-x" style="left: 0px; bottom: 0px;">
                <div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div>
            </div>
            <div class="ps__rail-y" style="top: 0px; right: 0px;">
                <div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 0px;"></div>
            </div>
        </div>
    </div>
</li>
