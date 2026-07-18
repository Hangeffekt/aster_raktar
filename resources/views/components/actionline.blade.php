@props([
    'page' => null,
    'filter' => [],
    'Brands' => null,
    'Catalogs' => null,
    'Taxes' => null,
])

<div class="row g-2 mb-3 align-items-center">
    <div class="col-12 col-lg-auto">
        <h4>{{ $page[0] }}</h4>
        <div class="btn-group">
            @can('create '.$page[1])
                <a href="/{{ $page[0] }}/create" class="btn btn-warning">Create</a>
            @endcan
            @if($filter[0] == 'on')
                @include('components.filters')
            @endif
        </div>
    </div>
</div>