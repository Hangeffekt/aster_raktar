<div class="mb-3">
    <h5>Calendar</h5>
    <form action="
    @if (Request::is('arrivals'))
        arrivals
    @elseif (Request::is('sales'))
        sales
    @elseif (Request::is('transfer'))
        transfer
    @endif
    " method="get">
        @csrf
        <div class="mb-3">
            <label for="" class="form-label">From</label>
            <input class="form-control" type="date" name="date-from">
        </div>
        <div class="mb-3">
            <label for="" class="form-label">To</label>
            <input class="form-control" type="date" name="date-to">
        </div>
        <input type="submit" value="check" class="btn btn-success" name="history">
    </form>
</div>