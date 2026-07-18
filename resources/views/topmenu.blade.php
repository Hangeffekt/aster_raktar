<div class="border-bottom p-3">
                <div class="row align-items-center g-3">

                    <!-- Search -->
                    <div class="col-12 col-lg">
                        <div class="input-group">
                            <span class="input-group-text">
                                <i class="bi bi-search"></i>
                            </span>
                            <input
                                type="text"
                                class="form-control"
                                placeholder="Keresés..."
                            >
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="col-12 col-lg-auto">
                        <div class="d-flex justify-content-lg-end gap-3">

                            <a href="#" class="notification-btn">
                                <i class="bi bi-bell-fill"></i>
                                <span class="notification-badge" id='notification-badge'></span>
                            </a>

                            <button class="btn btn-outline-secondary">
                                <i class="bi bi-gear"></i>
                            </button>

                            <form class="d-flex" method="post" action="/logout">
                                @csrf
                                <input class="btn btn-outline-danger" type="submit" value="Logout">
                            </form>

                        </div>
                    </div>

                </div>
            </div>
<div class="d-flex align-items-center gap-3">
    
    
</div>