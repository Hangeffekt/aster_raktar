@props([
    'headers' => [],
    'keys' => [],
    'items' => null,
    'page' => null,
    'actionTypes' => []
])

<table class="table table-hover">
    <thead class="bg-gray-50">
        <tr>
            @foreach($headers as $header)
                <th>
                    {{ $header }}
                </th>
            @endforeach
            @if(isset($actions))
                <th colspan="{{ count($actionTypes) }}">
                    Actions
                </th>
            @endif
        </tr>
    </thead>
    <tbody>
        @forelse($items as $item)
            <tr>
                @foreach($keys as $key)
                    <td>
                        {{ data_get($item, $key) }}
                    </td>
                    @endforeach
                    @if (in_array('show', $actionTypes))
                    <td>
                        @can('show '.$page[1])<a href="{{ route($page[0] . '.show', $item->uuid) }}" class="btn btn-info">Info</a>@endcan
                    </td>
                    @endif
                    @if (in_array('edit', $actionTypes))
                    <td>
                        @can('edit '.$page[1])<a href="{{ route($page[0] . '.edit', $item->uuid) }}" class="btn btn-warning">Edit</a>@endcan
                    </td>
                    @endif
                    @if (in_array('delete', $actionTypes))
                        @can('delete '.$page[1])
                            <td>
                                <form action="{{ route($page[0] . '.destroy', $item->uuid) }}" method="post">
                                    @csrf
                                    @method ('DELETE')
                                    <button class="btn btn-danger" type="submit">Delete</button>
                                </form>
                            </td>
                        @endcan
                    @endif
            </tr>
        @empty
            <tr>
                <td colspan="{{ count($headers) + (isset($actions) ? 1 : 0) }}">
                    There is no data!
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
{{ $items->withQueryString()->onEachSide(4)->links() }}