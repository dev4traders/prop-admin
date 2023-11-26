@foreach($options as $k => $label)
    <div class="form-check {{ $inline  ? 'form-check-inline' : '' }} form-check-{{ $style }} mt-3">
        <input class="form-check-input" type="radio" {!! $attributes !!} {!! in_array($k, $disabled) ? 'disabled' : '' !!} value="{{$k}}" {!! \Dcat\Admin\Support\Helper::equal($checked, $k) ? 'checked' : '' !!}>
        @if(!empty($label))<label class="form-check-label" for="radio{{$k}}">{!! $label !!}</label>@endif
    </div>
@endforeach
