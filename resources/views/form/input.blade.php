<div class="{{$viewClass['form-group']}}">

    <span class="{{$viewClass['label']}} col-form-label">{!! $label !!}</span>

    <div class="{{$viewClass['field']}}">

        @include('admin::form.error')

        <div class="input-group">

            @if ($prepend)
                <span class="input-group-text">{!! $prepend !!}</span>
            @endif
            <input {!! $attributes !!} />

            @if ($append)
                <span class="input-group-text">{!! $append !!}</span>
            @endif
        </div>

        @include('admin::form.help-block')

    </div>
</div>
