@if(Session::get('success'))
    <div class="col-12 alert alert-success">{{ Session::get('success') }}</div>
@elseif(Session::get('error'))
    <div class="col-12 alert alert-danger">{{ Session::get('error') }}</div>
@endif

@if (session('status'))
    <div class="col-12 alert alert-success">
        {{ session('status') }}
    </div>
@endif