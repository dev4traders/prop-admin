<li class="nav-item dropdown-style-switcher dropdown me-2 me-xl-0">
    <a class="nav-link dropdown-toggle hide-arrow" href="javascript:void(0);" data-bs-toggle="dropdown" aria-expanded="false">
    <i class="fas fa-{{ $current_mode }}"></i>
    </a>
    <ul class="dropdown-menu dropdown-menu-end dropdown-styles">
    <li>
        <a class="dropdown-item" href="javascript:void(0);" data-theme="light">
        <span class="align-middle"><i class="fas fa-sun me-2"></i>{{ __('admin.mode_light') }}</span>
        </a>
    </li>
    <li>
        <a class="dropdown-item" href="javascript:void(0);" data-theme="dark">
        <span class="align-middle"><i class="fa fa-moon me-2"></i>{{ __('admin.mode_dark') }}</span>
        </a>
    </li>
    <li>
        <a class="dropdown-item" href="javascript:void(0);" data-theme="system">
        <span class="align-middle"><i class="fa fa-desktop me-2"></i>{{ __('admin.mode_system') }}</span>
        </a>
    </li>
    </ul>
</li>
