<div class="{{$viewClass['form-group']}}">
    <label class="{{$viewClass['label']}} col-form-label">{!! $label !!}</label>
    <div class="{{$viewClass['field']}}">
        <input type="text" readonly="" class="{{$class}} form-control-plaintext" value="{!! $value !!}">
        @include('admin::form.help-block')

    </div>
</div>
