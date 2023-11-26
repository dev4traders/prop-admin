@if ($grid->allowPagination())
    <div class="row">
        <div class="col-sm-12 col-md-6">
            <div class="dataTables_info" id="DataTables_Table_2_info" role="status" aria-live="polite">{{ __('admin.pagination.range', [
                'first' => $grid->paginator->firstItem(),
                'last'  => $grid->paginator->lastItem(),
                'total' => $grid->paginator->total()] ) }}
            </div>
        </div>
        <div class="col-sm-12 col-md-6 dataTables_pager">
            <div class="dataTables_paginate paging_simple_numbers" id="DataTables_Table_0_paginate">
                <ul class="pagination">
                    <li class="page-item">
                        @if($grid->getPerPages() != [])
                            {!! $grid->perPageSelector->render() !!}
                        @endif
                    </li>
                    <!-- Previous Page Link -->
                    @if ($grid->paginator->onFirstPage())
                    <li class="paginate_button page-item previous disabled">
                        <a aria-controls="DataTables_Table_0" aria-disabled="true" role="link" data-dt-idx="previous" tabindex="-1" class="page-link">{{ __('admin.pagination.previous') }}</a>
                    </li>
                    @else
                    <li class="paginate_button page-item previous">
                        <a href="{{ $grid->paginator->previousPageUrl() }}" aria-controls="DataTables_Table_0" role="prev" data-dt-idx="previous" tabindex="0" class="page-link">{{ __('admin.pagination.previous') }}</a>
                    </li>
                    @endif

                    @if(! empty($grid->paginator->elements))
                    @foreach ($elements as $element)
                        <!-- "Three Dots" Separator -->
                        @if (is_string($element))
                        <li class="page-item disabled"><span class="page-link">{{ $element }}</span></li>
                        @endif

                        <!-- Array Of Links -->
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $grid->paginator->currentPage())
                                <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                                @else
                                <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                @endif
                            @endforeach
                        @endif
                    @endforeach
                    @endif

                    <!-- Next Page Link -->
                    @if ($grid->paginator->hasMorePages())
                    <li class="paginate_button  page-item next">
                        <a class="page-link" href="{{ $grid->paginator->nextPageUrl() }}" rel="next">{{ __('admin.pagination.next') }}</a>
                    </li>
                    @else
                    <li class="paginate_button  page-item next disabled">
                        <a aria-controls="DataTables_Table_1" aria-disabled="true" role="link" data-dt-idx="next" tabindex="-1" class="page-link">{{ __('admin.pagination.next') }}</a>
                    </li>
                    @endif
                </ul>
            </div>
        </div>
    </div>
@endif
