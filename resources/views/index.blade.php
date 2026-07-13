<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-0evHe/X+R7YkIZDRvuzKMRqM+OrBnVFBL6DOitfPri4tjfHxaWutUpFmBp4vmVor" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet"href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/mdb.dark.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ URL::asset('css/style.css') }}">
    <script type="text/javascript" src="{{ URL::asset('js/jquery-3.5.1.js') }}"></script>
    <script type="text/javascript" src="{{ URL::asset('js/js.js') }}"></script>
    <title>Document</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
<div class="container">
        <div class="row">
            <div class="col-12">
                @include("menu")
                @include("alert")
            </div>
            <div class="col-lg-12 col-sm-12">
                <div class="row mt-3">
                    @yield("content")
                </div>
            </div>
        </div>
    </div>
   

</body>
</html>