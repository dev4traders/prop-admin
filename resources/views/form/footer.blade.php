<div class="card-footer">
<div class="row">
    <div class="col-md-{{$width['label']}} d-md-block" style="display: none"></div>
    <div class="col-md-{{$width['field']}}">

        @if(! empty($buttons['submit']))
            <div class="btn-group float-end">
                <button class="btn btn-primary submit"><i class="bx bx-save"></i> {{ trans('admin.submit') }}</button>
            </div>

            @if($checkboxes)
                <div class="float-end d-md-flex" style="display: none">{!! $checkboxes !!}</div>
            @endif

        @endif

        @if(! empty($buttons['reset']))
        <div class="btn-group float-start">
            <button type="reset" class="btn btn-outline-primary"><i class="bx bx-icon-rotate"></i> {{ trans('admin.reset') }}</button>
        </div>
        @endif
    </div>
</div>
</div>
