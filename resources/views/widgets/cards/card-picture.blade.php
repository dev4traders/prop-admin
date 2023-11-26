<div class="card">
    <div class="d-flex align-items-end row">
    <div class="col-sm-7">
        <div class="card-body">
        <h5 class="card-title text-primary">{{ $title }}</h5>
        <p class="mb-4">{{ $description }}</p>

        <a href="{{ $link }}" class="btn btn-sm btn-outline-primary">{{ __('admin.details') }}</a>
        </div>
    </div>
    <div class="col-sm-5 text-center text-sm-left">
        <div class="card-body pb-0 px-0 px-md-4">
            {!! $image !!}
        </div>
    </div>
    </div>
</div>
