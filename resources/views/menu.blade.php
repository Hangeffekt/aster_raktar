@if (Auth::check())
<aside class="col-12 col-md-3 col-lg-2 border-end">
  <div class="p-3">

    <h4 class="mb-4">Admin Panel</h4>
    <ul class="nav flex-column gap-2">
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="#">Dashboard</a>
        </li>
        @can('show stocks')
          <li class="nav-item">
            <a
                class="nav-link d-flex justify-content-between align-items-center"
                data-bs-toggle="collapse"
                href="#stockDropdown"
                role="button"
                aria-expanded="false"
                aria-controls="stockDropdown">
                Stock
                <i class="bi bi-chevron-down"></i>
            </a>

            <div class="collapse" id="stockDropdown">
                <ul class="nav flex-column ms-3 mt-2">
                    @can('show arrivals')
                        <li><a class="nav-link" href="/arrivals">Arrival</a></li>
                    @endcan

                    @can('show transfers')
                        <li><a class="nav-link" href="/transfer">Transfer</a></li>
                    @endcan

                    @can('show adjustments')
                        <li><a class="nav-link" href="/inventory-adjustments">Inventory adjustment</a></li>
                    @endcan

                    <li><a class="nav-link" href="#">Stocktake</a></li>
                </ul>
            </div>
          </li>
        @endcan

        @can('show sales')
          <li class="nav-item">
            <a class="nav-link" href="/sales">Sale</a>
          </li>  
        @endcan
        @can('show main_datas')
          <li class="nav-item">
            <a
                class="nav-link d-flex justify-content-between align-items-center"
                data-bs-toggle="collapse"
                href="#mainDatasDropdown"
                role="button"
                aria-expanded="false"
                aria-controls="mainDatasDropdown">
                Main datas
                <i class="bi bi-chevron-down"></i>
            </a>
            <div class="collapse" id="mainDatasDropdown">
                <ul class="nav flex-column ms-3 mt-2">
                  @can('show main_datas_products')
                    <li class="nav-item">
                      <a class="nav-link @if(Request::is('products')) active @endif" href="/products">Products</a>
                    </li> 
                  @endcan
                  @can('show main_datas_brands')
                    <li class="nav-item">
                      <a class="nav-link @if(Request::is('brands')) active @endif" href="/brands">Brands</a>
                    </li> 
                  @endcan
                  @can('show main_datas_catalogs')
                    <li class="nav-item">
                      <a class="nav-link @if(Request::is('catalogs')) active @endif" href="/catalogs">Catalogs</a>
                    </li> 
                  @endcan
                  @can('show main_datas_shop')
                    <li class="nav-item">
                      <a class="nav-link @if(Request::is('shops')) active @endif" href="/shops">Shops</a>
                    </li>
                  @endcan
                  @can('show main_datas_taxes')
                    <li class="nav-item">
                      <a class="nav-link @if(Request::is('taxes')) active @endif" href="/taxes">Taxes</a>
                    </li> 
                  @endcan
                  @can('show main_datas_supliers')
                    <li class="nav-item">
                      <a class="nav-link @if(Request::is('supliers')) active @endif" href="/supliers">Supliers</a>
                    </li> 
                  @endcan
                  @can('show main_datas_payment_types')
                    <li class="nav-item">
                      <a class="nav-link @if(Request::is('paymenttypes')) active @endif" href="/paymenttypes">Payment types</a>
                    </li> 
                  @endcan
                  @can('show main_datas_moduls')
                    <li class="nav-item">
                      <a class="nav-link @if(Request::is('moduls')) active @endif" href="/moduls">Moduls</a>
                    </li> 
                  @endcan
                  @can('show main_datas_users')
                    <li class="nav-item">
                      <a class="nav-link @if(Request::is('users')) active @endif" href="/users">Users</a>
                    </li> 
                  @endcan
                  @can('show main_datas_roles')
                    <li class="nav-item">
                      <a class="nav-link @if(Request::is('roles')) active @endif" href="/roles">Roles</a>
                    </li> 
                  @endcan
                  @can('show main_datas_permissions')
                    <li class="nav-item">
                      <a class="nav-link @if(Request::is('permissions')) active @endif" href="/permissions">Permissions</a>
                    </li> 
                  @endcan
              </ul>
            </div>
          </li>
        @endcan
        @can('show arrivals')
          <li class="nav-item">
            <a class="nav-link" href="">Finance</a>
          </li>
        @endcan
    </ul>
  </div>
</aside>
@endif