<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('APP_NAME', 'Monitoring Ketinggian Air Sumur') }}</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="icon" type="image/png" href="{{ asset('img/logo-kpspams.png') }}">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRkIbggVph5FhAB6AA6MOGBHRm5y0uC1knBGeox7D" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            background-color: rgb(58, 124, 165);
        }

        .container {
            background-color: rgb(58, 124, 165);
        }

        .card {
            background-color: white;
        }

        .sidebar {
            background-color: #6395ec;
            min-height: 100vh;
            color: white;
            position: fixed;
            top: 0;
            left: 0;
            width: 250px;
            margin-left: -30px
        }

        .sidebar .nav-link {
            color: white;
            margin: 10px 0;
        }

        .sidebar .nav-link:hover {
            color: #e0e0e0;
            background-color: #4a77d1;
            border-radius: 4px;
        }

        .sidebar .nav-link.active {
            background-color: #4a77d1;
        }

        .content {
            margin-left: 260px;
            /* Adjust to the width of the sidebar */
            padding: 20px;
        }
    </style>
</head>

<body>
    <div class="sidebar">
        <nav class="navbar navbar-expand-lg navbar-light flex-column">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav flex-column">
                    <li class="nav-item">
                        <a class="nav-link" href="/"><i class="fa-solid fa-house"></i> PAM Sagara</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/about"><i class="fa-solid fa-circle-info"></i> Tentang Alat</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/dashboard"><i class="fa-solid fa-chart-line"></i> Monitoring</a>
                    </li>
                    @auth
                        @if (Auth::user()->isAdmin())
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('history') }}"><i class="fa-solid fa-book"></i> Riwayat</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('users') }}"><i class="fa-solid fa-user"></i> Users</a>
                            </li>
                        @endif
                    @endauth
                    @auth
                        @if (Auth::user()->isAdmin() || Auth::user()->isCustomer())
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('contact') }}"><i class="fa-solid fa-phone"></i> Layanan</a>
                            </li>
                            
                        @endif
                    @endauth
                    @guest
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}"><i class="fa-solid fa-right-to-bracket"></i>
                                Login</a>
                        </li>
                    @endguest
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="#"
                                onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                                    class="fa-solid fa-right-to-bracket"></i>
                                Logout
                            </a>
                            <form id="logout-form" action="{{ route('logout') }}" method="GET" style="display: none;">
                                @csrf
                            </form>
                        </li>
                    @endauth

                </ul>
            </div>
        </nav>
    </div>

    <div class="content">
        <nav aria-label="breadcrumb"
            style="margin-top: -30px; background-color: #6395ec; margin-left: -59px; margin-right:-2%; padding-bottom: 0.9px;">
            <ol class="breadcrumb" style="margin-left: 7px; color: white; margin-top: 10px">
                <li class="breadcrumb-item">PAM Sagara</li>
                @if (Request::is('about'))
                    <li class="breadcrumb-item active" aria-current="page">Tentang Alat</li>
                @elseif (Request::is('dashboard'))
                    <li class="breadcrumb-item active" aria-current="page">Monitoring</li>
                @elseif (Request::is('history'))
                    <li class="breadcrumb-item active" aria-current="page">Riwayat</li>
                @elseif (Request::is('contact'))
                    <li class="breadcrumb-item active" aria-current="page">Layanan</li>
                @elseif (Request::is('login'))
                    <li class="breadcrumb-item active" aria-current="page">Login</li>
                @endif
            </ol>
        </nav>

        <div class="container" style="text-align:center; margin-top:10px;">
            @yield('content')
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
</body>

</html>
