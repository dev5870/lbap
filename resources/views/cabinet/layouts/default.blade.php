<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"/>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <meta
        content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no"
        name="viewport"
    />

    <title>{{ $settings->site_name }}</title>

    <link rel="icon" type="image/png" href="{{ asset('assets/img/logo.png') }}">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3"
        crossorigin="anonymous"
    />
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet"/>
    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css"/>
    <link href="{{ asset('assets/css/app.css') }}" rel="stylesheet"/>
</head>
<body data-sidebar-behavior="sticky">
<div class="wrapper">
    @include('cabinet.includes.nav')
    <div class="main">
        @include('cabinet.includes.top-nav')
        <div class="content">
            @include('cabinet.includes.alerts')
            @yield('content')
        </div>
        <footer class="footer">
            <div class="container-fluid">
                <div class="text-muted row">
                    <div class="text-start col-6">
                        <ul class="list-inline">
                            <li class="list-inline-item"><span class="text-muted" href="#">Support</span></li>
                            <li class="list-inline-item"><span class="text-muted" href="#">Help Center</span></li>
                            <li class="list-inline-item"><span class="text-muted" href="#">Privacy</span></li>
                            <li class="list-inline-item"><span class="text-muted" href="#">Terms of Service</span></li>
                        </ul>
                    </div>
                    <div class="text-end col-6">
                        <p class="mb-0">
                            © 2022 -
                            <span href="/" class="text-muted">{{ $settings->site_name }}</span>
                        </p>
                    </div>
                </div>
            </div>
        </footer>

    </div>
</div>

<script type="text/javascript" src="https://cdn.jsdelivr.net/jquery/latest/jquery.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script
    src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"
    integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB"
    crossorigin="anonymous"
>
</script>
<script
    src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js"
    integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13"
    crossorigin="anonymous"
>
</script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/feather-icons/dist/feather.min.js"></script>
<script src="{{ asset('assets/js/app.js') }}"></script>

</body>
</html>
