<table class="table table-bordered">
    <thead>
        <th>Player</th>
        <th>Statistic</th>
        <th>Value</th>
        <th>Year</th>
    </thead>
    <tbody>
        @if (isset($data))
        @foreach ($data as $item)
        <tr>
            <td>{{ $item->player ? $item->player->last_name : 'n/a' }}</td>
            <td>{{ $item->param_name }}</td>
            <td>{{ $item->total_value }}</td>
            <td>{{ $year }}</td>
        </tr>
        @endforeach
        @endif
    </tbody>
</table>
<div id="paginationLinks">
    @if (isset($data))
    @include('sections.pagination', ['paginator' => $data]).
    @endif
</div>