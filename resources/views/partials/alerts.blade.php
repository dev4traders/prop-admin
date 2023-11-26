@if($error = session()->get('error'))
    <div role="alert" class="alert alert-danger d-flex alert-dismissible">
        <span class="badge badge-center rounded-pill bg-danger border-label-danger p-3 me-2"><i class="fa fa-ban fs-6"></i></span>
        <div class="d-flex flex-column ps-1">
            <h6 class="alert-heading d-flex align-items-center mb-1">{{ \Illuminate\Support\Arr::get($error->get('title'), 0) }}</h6>
            <span>{!!  \Illuminate\Support\Arr::get($error->get('message'), 0) !!}</span>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@elseif ($errors = session()->get('errors'))
    @if ($errors->hasBag('error'))
        <div role="alert" class="alert alert-danger alert-dismissible">
        @foreach($errors->getBag("error")->toArray() as $message)
            <p>{!!  \Illuminate\Support\Arr::get($message, 0) !!}</p>
        @endforeach
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
      </div>
    @endif
@endif
@if($success = session()->get('success'))
    <div role="alert" class="alert alert-success d-flex alert-dismissible">
        <span class="badge badge-center rounded-pill bg-success border-label-danger p-3 me-2"><i class="fa fa-check fs-6"></i></span>
        <div class="d-flex flex-column ps-1">
            <h6 class="alert-heading d-flex align-items-center mb-1">{{ \Illuminate\Support\Arr::get($success->get('title'), 0) }}</h6>
            <span>{!!  \Illuminate\Support\Arr::get($success->get('message'), 0) !!}</span>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
@if($info = session()->get('info'))
    <div role="alert" class="alert alert-info d-flex alert-dismissible">
        <span class="badge badge-center rounded-pill bg-info border-label-danger p-3 me-2"><i class="fa fa-info fs-6"></i></span>
        <div class="d-flex flex-column ps-1">
            <h6 class="alert-heading d-flex align-items-center mb-1">{{ \Illuminate\Support\Arr::get($info->get('title'), 0) }}</h6>
            <span>{!!  \Illuminate\Support\Arr::get($info->get('message'), 0) !!}</span>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif
@if($warning = session()->get('warning'))
    <div role="alert" class="alert alert-warning d-flex alert-dismissible">
        <span class="badge badge-center rounded-pill bg-warning border-label-danger p-3 me-2"><i class="fa fa-warning fs-6"></i></span>
        <div class="d-flex flex-column ps-1">
            <h6 class="alert-heading d-flex align-items-center mb-1">{{ \Illuminate\Support\Arr::get($warning->get('title'), 0) }}</h6>
            <span>{!!  \Illuminate\Support\Arr::get($warning->get('message'), 0) !!}</span>
        </div>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
@endif