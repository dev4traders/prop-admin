<div class="card">
    <div class="card-header">
        {!! $grid->renderFilter() !!}

        {!! $grid->renderHeader() !!}
    </div>
    <div class="card-datatable table-responsive">
        <div id="DataTables_Table_2_wrapper" class="dataTables_wrapper dt-bootstrap5">
            @include('admin::grid.table-toolbar')

            <div class="{!! $grid->formatTableParentClass() !!}">
                <table class="{{ $grid->formatTableClass() }}" id="{{ $tableId }}" >
                    <thead>
                    @if ($headers = $grid->getVisibleComplexHeaders())
                        <tr>
                            @foreach($headers as $header)
                                {!! $header->render() !!}
                            @endforeach
                        </tr>
                    @endif
                    <tr>
                        @foreach($grid->getVisibleColumns() as $column)
                            <th {!! $column->formatTitleAttributes() !!}>{!! $column->getLabel() !!}{!! $column->renderHeader() !!}</th>
                        @endforeach
                    </tr>
                    </thead>

                    @if ($grid->hasQuickCreate())
                        {!! $grid->renderQuickCreate() !!}
                    @endif

                    <tbody>
                    @foreach($grid->rows() as $row)
                        <tr {!! $row->rowAttributes() !!}>
                            @foreach($grid->getVisibleColumnNames() as $name)
                                <td {!! $row->columnAttributes($name) !!}>{!! $row->column($name) !!}</td>
                            @endforeach
                        </tr>
                    @endforeach
                    @if ($grid->rows()->isEmpty())
                        <tr>
                            <td colspan="{!! count($grid->getVisibleColumnNames()) !!}">
                                <div style="margin:5px 0 0 10px;"><span class="help-block" style="margin-bottom:0"><i class="feather icon-alert-circle"></i>&nbsp;{{ trans('admin.no_data') }}</span></div>
                            </td>
                        </tr>
                    @endif
                    </tbody>
                </table>
            </div>

            {!! $grid->renderFooter() !!}

            {!! $grid->renderPagination() !!}
        </div>
    </div>
</div>
