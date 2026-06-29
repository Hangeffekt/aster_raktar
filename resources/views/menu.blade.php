@if (Auth::check())
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
      <div class="navbar-nav">
        <a class="nav-link active" aria-current="page" href="#">Kezdőlap</a>
        <a class="nav-link" href="/arrivals">Arrival</a>
        <a class="nav-link" href="/sales">Sale</a>
        <a class="nav-link" href="/transfer">Transfer</a>
        <a class="nav-link" href="/products">Main datas</a>
        <a class="nav-link" href="">Finance</a>
      </div>
      <form class="d-flex" method="post" action="/logout">
        @csrf
        <input class="btn btn-outline-danger" type="submit" value="Logout">
      </form>
  </div>
</nav>
@endif