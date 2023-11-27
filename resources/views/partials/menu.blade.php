@php
    $depth = $item['depth'] ?? 0;
@endphp
@if($builder->visible($item))
    @if(empty($item['children']))
        <li class="menu-item {!! $builder->isActive($item) ? 'active' : '' !!}">
            <a data-pjax data-id="{{ $item['id'] ?? '' }}" @if(mb_strpos($item['uri'], '://') !== false) target="_blank" @endif
               href="{{ $builder->getUrl($item['uri']) }}"
               class="menu-link">
                <i class="menu-icon {{ $builder->getIcon($item) }}"></i>
                <div class="text-truncate">
                    {!! $builder->translate($item['title']) !!}
                </div>
            </a>
        </li>
    @else
        <li class="menu-item {{ $builder->isActive($item) ? 'open active' : '' }}">
            <a href="javascript:void(0);"  data-id="{{ $item['id'] ?? '' }}"
               class="menu-link menu-toggle">
                <i class="menu-icon {{ $builder->getIcon($item) }}"></i>
                <div class="text-truncate">
                    {!! $builder->translate($item['title']) !!}
                </div>
            </a>
            <ul class="menu-sub">
                @foreach($item['children'] as $item)
                    @php
                        $item['depth'] = $depth + 1;
                    @endphp

                    @include('admin::partials.menu', ['item' => $item])
                @endforeach
            </ul>
        </li>
    @endif
@endif
