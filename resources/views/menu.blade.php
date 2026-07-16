@if (Auth::check())
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
      <div class="navbar-nav">
        <a class="nav-link active" aria-current="page" href="#">Kezdőlap</a>
          @can('show stocks')<li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
              Stock
            </a>
            <ul class="dropdown-menu">
              @can('show arrivals')<li><a class="dropdown-item" href="/arrivals">Arrival</a></li>@endcan
              @can('show transfers')<li><a class="dropdown-item" href="/transfer">Transfer</a></li>@endcan
              @can('show adjustments')<li><a class="dropdown-item" href="/inventory-adjustments">Inventory adjustment</a></li>@endcan
              <li><a class="dropdown-item" href="#">Stocktake</a></li>
            </ul>
          </li>
        @endcan
        
        @can('show sales')<a class="nav-link" href="/sales">Sale</a>@endcan
        @can('show main_datas')<a class="nav-link" href="/products">Main datas</a>@endcan
        @can('show arrivals')<a class="nav-link" href="">Finance</a>@endcan
      </div>
      <div class="d-flex align-items-center gap-3">
        <a href="#" class="notification-btn">
            <i class="bi bi-bell-fill"></i>
            <span class="notification-badge" id='notification-badge'></span>
        </a>
        <form class="d-flex" method="post" action="/logout">
          @csrf
          <input class="btn btn-outline-danger" type="submit" value="Logout">
        </form>
      </div>
  </div>
</nav>
@endif