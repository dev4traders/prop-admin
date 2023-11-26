@if ($grid->allowToolbar())
    <div class="row mx-2">
        @if(!empty($title))
            <h4 class="float-start" style="margin:5px 10px 0;">
                {!! $title !!}&nbsp;
                @if(!empty($description))
                    <small>{!! $description!!}</small>
                @endif
            </h4>
            <div class="float-end" data-responsive-table-toolbar="{{$tableId}}">
                {!! $grid->renderTools() !!}
                {!! $grid->renderColumnSelector() !!}
                {!! $grid->renderCreateButton() !!}
                {!! $grid->renderExportButton() !!}
                {!! $grid->renderQuickSearch() !!}
            </div>
        @else
            <div class="col-md-2">
                {!! $grid->renderTools() !!}  {!! $grid->renderQuickSearch() !!}
            </div>
            <div class="col-md-10">
                {{-- todo::rm --}}
                {{-- <div class="float-end" data-responsive-table-toolbar="{{$tableId}}"> --}}
                <div class="dt-action-buttons text-xl-end text-lg-start text-md-end text-start d-flex align-items-center justify-content-end flex-md-row flex-column mb-3 mb-md-0">
                    {!! $grid->renderColumnSelector() !!}
                    {!! $grid->renderCreateButton() !!}
                    {!! $grid->renderExportButton() !!}
                </div>
            </div>
        @endif
    </div>
@endif
