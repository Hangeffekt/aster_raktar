@if (Auth::check())
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
      <div class="navbar-nav">
        <a class="nav-link active" aria-current="page" href="#">Kezdőlap</a>
        @can('show arrivals')<a class="nav-link" href="/arrivals">Arrival</a>@endcan
        @can('show sales')<a class="nav-link" href="/sales">Sale</a>@endcan
        @can('show transfers')<a class="nav-link" href="/transfer">Transfer</a>@endcan
        @can('show main_datas')<a class="nav-link" href="/products">Main datas</a>@endcan
        @can('show arrivals')<a class="nav-link" href="">Finance</a>@endcan
      </div>
      <form class="d-flex" method="post" action="/logout">
        @csrf
        <input class="btn btn-outline-danger" type="submit" value="Logout">
      </form>
  </div>
</nav>
@endif