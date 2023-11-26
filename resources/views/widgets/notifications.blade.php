<li class="nav-item dropdown-notifications navbar-dropdown dropdown me-3 me-xl-1">
    <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
    <i class="bx bx-bell bx-sm"></i>
    <span class="badge bg-danger rounded-pill badge-notifications">{{ count($items) }}</span>
    </a>
    <ul class="dropdown-menu dropdown-menu-end py-0">
    <li class="dropdown-menu-header border-bottom">
        <div class="dropdown-header d-flex align-items-center py-3">
        <h5 class="text-body mb-0 me-auto">{{ __('admin.notifications')}}</h5>
        <a href="javascript:void(0)" class="dropdown-notifications-all text-body" data-bs-toggle="tooltip" data-bs-placement="top" aria-label="{{ __('admin.mark_all_as_read') }}" data-bs-original-title="{{ __('admin.mark_all_as_read') }}"><i class="bx fs-4 bx-envelope-open"></i></a>
        </div>
    </li>

    <li class="dropdown-notifications-list scrollable-container ps ps--active-y">
        <ul class="list-group list-group-flush">
            @foreach($items as $item )
            <li class="list-group-item list-group-item-action dropdown-notifications-item {{ $item['is_read'] ? 'marked-as-read' : '' }}">
                <div class="d-flex">
                <div class="flex-shrink-0 me-3">
                    <div class="avatar">
                        <span class="avatar-initial rounded-circle bg-label-{{ $item['class'] }}"><i class="bx {{ $item['icon'] }}"></i></span>
                    </div>
                </div>
                <div class="flex-grow-1">
                    <h6 class="mb-1">{{ $item['title'] }}</h6>
                    <p class="mb-0">{{ $item['message'] }}</p>
                    <small class="text-muted">{{ $item['time'] }}</small>
                </div>
                <div class="flex-shrink-0 dropdown-notifications-actions">
                    <a href="javascript:void(0)" class="dropdown-notifications-read"><span class="badge badge-dot"></span></a>
                    <a href="javascript:void(0)" class="dropdown-notifications-archive"><span class="bx bx-x"></span></a>
                </div>
                </div>
            </li>
            @endforeach
        </ul>
    <div class="ps__rail-x" style="left: 0px; bottom: 0px;"><div class="ps__thumb-x" tabindex="0" style="left: 0px; width: 0px;"></div></div><div class="ps__rail-y" style="top: 0px; right: 0px; height: 480px;"><div class="ps__thumb-y" tabindex="0" style="top: 0px; height: 407px;"></div></div></li>
    <li class="dropdown-menu-footer border-top p-3">
        <a href='{{ $view_all_link }}'>
            <button class="btn btn-primary text-uppercase w-100">{{ __('admi.view_all_notifications') }}</button>
        </a>
    </li>
    </ul>
</li>
