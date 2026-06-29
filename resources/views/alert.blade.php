@if(Session::get('success'))
    <div class="col-12 alert alert-success">{{ Session::get('success') }}</div>
@endif

@if (session('status'))
    <div class="col-12 alert alert-success">
        {{ session('status') }}
    </div>
@endif