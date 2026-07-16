@props([
    'headers' => [],
    'keys' => [],
    'items' => null
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
                <th>
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
                @if(isset($actions))
                    <td>
                        {{ $actions }}
                    </td>
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