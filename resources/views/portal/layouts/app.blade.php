<!DOCTYPE html>

<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('page_title', config('app.name'))</title>



    {{-- Page Meta Data, Robots, index ect --}}
    <meta name="robots" content="noindex, nofollow" />
    @yield('page_meta')

    {{-- Header Css files --}}
    @section('header_css')
        <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:ital,wght@0,400;0,600;0,700;1,400;1,600;1,700&display=swap" rel="stylesheet">
        <link href="{{ mix('assets/portal/css/app.css') }}" type="text/css" rel="stylesheet" media="screen,projection"/>
    @show
    <link href="/assets/portal/images/fav.png" rel="icon" type="image/x-icon" />

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body class="" style="height: 100%!important;">

    @yield('content')

{{-- Footer Javascript files --}}
@section('footer_javascript')
    <script>
        window.Laravel = {!! json_encode(['csrfToken' => csrf_token()]) !!};
    </script>
    <script async type="text/javascript" src="{{ mix('assets/portal/js/app.js') }}"></script>
@show
<!-- Netmatters Uptime Ping Test Response -->
</body>
</html>
