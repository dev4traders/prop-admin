<div class="btn-group">
    @if(!empty($button['split']) && $button['split'])
        <button type="button" class="{{$button['class']}} {{$button['size_class']}} {{$button['arrow'] ? 'hide-arrow' : ''}} {{$rounded ? 'rounded-pill' : ''}}">
            {{$button['text']}}
        </button>
    @endif
    <button type="button" class="{{$button['class']}} {{$button['size_class']}} dropdown-toggle {{$button['split'] ? 'dropdown-toggle-split' : ''}}
     {{$button['arrow'] ? 'hide-arrow' : ''}} {{$rounded ? 'rounded-pill' : ''}}" id="{{$buttonId}}" data-bs-toggle="dropdown" aria-expanded="false">
        @if(!empty($button['split']) && $button['split'])
            <span class="visually-hidden">{{$button['text']}}</span>
        @elseif(!empty($button['icon']))
            <i class="{{$button['icon']}}"></i>{{$button['text']}}
        @else
            {{$button['text']}}
        @endif
    </button>
    <ul class="dropdown-menu">
        @foreach($items as $item)
            @if($item->hasDivider)
                <hr class="dropdown-divider">
            @endif
            <li><a class="dropdown-item {{$item->isDisabled ? 'disabled' : ''}}"
                   href="{{ $item->link ?? '#' }}">{{$item->value}}</a>
            </li>
        @endforeach
    </ul>
</div>
@if($click)
    <script>
        var $btn = $('#{{ $buttonId }}'),
            $a = $btn.parent().find('ul li a'),
            text = String($btn.text());

        $a.on('click', function () {
            $btn.find('stub').html($(this).html() + ' &nbsp;');
        });

        if (text.replace(/(^\s*)|(\s*$)/g, "")) {
            $btn.find('stub').html(text + ' &nbsp;');
        } else {
            (!$a.length) || $btn.find('stub').html($($a[0]).html() + ' &nbsp;');
        }
    </script>
@endif
