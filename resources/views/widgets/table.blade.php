<div class="table-responsive text-nowrap">
    <table class="table {{ is_null($class) ? '' : 'table-'.$class }} {{ $striped ? 'table-striped' : '' }} {{ $withBorder ? 'table-bordered' : '' }} {{ $withHover ? 'table-hover' : '' }} {{ $small ? 'table-sm' : '' }}">
        <thead class="{{ is_null($headerClass) ? '' : 'table-'.$headerClass }}">
        <tr>
            @foreach($headers as $header)
                <th>{{ $header }}</th>
            @endforeach
        </tr>
        </thead>
        <tbody>
        @foreach($rows as $row)
        <tr>
            @foreach($row as $item)
            <td>{!! $item !!}</td>
            @endforeach
        </tr>
        @endforeach
        @if (empty($rows))
            <tr>
                <td valign="top" class="dataTables_empty" colspan="{!! count($headers) !!}">
                    {{ trans('admin.no_data') }}
                </td>
            </tr>
        @endif
        </tbody>
        @if($withFooter)
        <tfoot class="table-border-bottom-0">
        <tr>
            @foreach($headers as $header)
                <th>{{ $header }}</th>
            @endforeach
        </tr>
        </tfoot>
        @endif
    </table>
</div>
