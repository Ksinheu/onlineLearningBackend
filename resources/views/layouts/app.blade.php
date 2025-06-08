<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <!-- Scripts -->
    <!-- Tailwind CSS CDN -->

    {{-- <link href="dist/output.css" rel="stylesheet"> --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Suwannaphum:wght@100;300;400;700;900&display=swap');

        * {
            font-family: "Suwannaphum", serif;
        }

        .bg-Blue {
            background-color: #080c79;

        }

        .bg-darkBlue {
            background-color: #2e3190;

        }

        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 265px;
            padding-top: 20px;
            background-color: #080c79;
            transition: width 0.3s;
        }

        .sidebar .nav-link {
            display: flex;
            align-items: center;
            gap: 20px;
            padding: 10px 40px;
            color: #fff;
        }

        .sidebar .description {
            font-size: 14px;
        }

        .sidebar .nav-link:hover {
            background-color: #0254d8
        }

        @media(max-width: 480px) {
            .sidebar {
                width: 60px;
            }

            .sidebar .description {
                display: none;
            }

            .sidebar .nav-link {
                justify-content: center;
            }
        }

        /* body {
    display: flex;
    font-family: Arial, sans-serif;
    margin: 0;
} */

        .sidebar {
            width: 265px;
            background: #04155f;
            color: white;
            padding: 20px;
            height: 100vh;
        }

        .sidebar h2 {
            text-align: center;
        }

        .sidebar ul {
            list-style: none;
            padding: 0;
        }

        .sidebar ul li {
            padding: 10px;
            cursor: pointer;
        }

        .sidebar ul li.active {
            color: #d6b861;
            text-decoration: underline;
        }

        .main-content {
            flex: 1;
            padding: 20px;
        }

        header {
            background: white;
            padding: 15px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        .stats {
            display: flex;
            gap: 20px;
            flex-wrap: wrap;
        }

        .card {
            background: white;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.2);
            flex: 1;
            min-width: 200px;
            text-align: center;
        }
    </style>
</head>

<body class="bg-secondary-subtle">
    <div class="container-fluid">

        <div class="row">

            <div class="col-2" style="box-shadow: rgba(0, 0, 0, 0.15) 2.4px 2.4px 3.2px;">

                <div class="sidebar">

                    <nav class="nav flex-column">
                        <a href="" class="mb-4 ">
                            <div>
                                <img src="{{ asset('images/pcc-logo.png') }}" alt="" class="w-100">
                            </div>
                        </a>
                        <a href="{{ route('dashboard') }}" class="nav-link">
                            <span class="icon"><i class="fa-solid fa-gauge"></i></span>
                            <span class="description">Dashboard</span>
                        </a>
                        <a href="{{ route('course.index') }}" class="nav-link"
                            {{ Request::routeIs('course.index') ? 'active' : '' }}>
                            <span class="icon"><i class="fa-solid fa-list"></i></span>
                            <span class="description">Course</span>
                        </a>
                        <a href="{{ route('lession.index') }}" class="nav-link"
                            {{ Request::routeIs('lession.index') ? 'active' : '' }}>
                            <span class="icon"><i class="fa-solid fa-film"></i></span>
                            <span class="description">Lesson</span>
                        </a>
                        <a href="{{ route('assignment.index') }}" class="nav-link"
                            {{ Request::routeIs('assignment.index') ? 'active' : '' }}>
                            <span class="icon"></span>
                            <span class="description">Assignment</span>
                        </a>
                        <a href="" class="nav-link">
                            <span class="icon"></span>
                            <span class="description">Payment</span>
                        </a>
                        <a href="{{ route('notification.index') }}" class="nav-link" {{ Request::routeIs('notification.index') ? 'active' : '' }}>
                            <span class="icon"></span>
                            <span class="description">Notification</span>
                        </a>
                        <a href="" class="nav-link" data-bs-target="#submenu" aria-controls="submenu"
                            data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false">
                            <span class="icon"></span>
                            <span class="description">Setting</span>
                        </a>

                        <div class="sub-menu collapse" id="submenu">

                            <a href="{{ route('slider.index') }}" class="nav-link"
                                {{ Request::routeIs('slider.index') ? 'active' : '' }}>
                                <span class="icon">
                                </span>
                                <span class="description">Slider</span>
                            </a>
                            <a href="{{ route('news.index') }}" class="nav-link"
                                {{ Request::routeIs('news.index') ? 'active' : '' }}>
                                <span class="icon">

                                </span>
                                <span class="description">News</span>
                            </a>
                        </div>
                    </nav>
                </div>
            </div>
            
            <div class="col-10 p-3 justify-content-center">



                <div class="card rounded mb-4">
                    <div class="row">
                        <div class="col-10"></div>
                        <div class="col-2 text-center">
                            <!-- User Dropdown -->
                            <div class="dropdown justify-content-end">
                                <button class="btn btn-outline-success dropdown-toggle" type="button" id="userDropdown"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    {{ Auth::user()->name }}
                                </button>
                                <ul class="dropdown-menu" aria-labelledby="userDropdown">
                                    <!-- Profile Link -->
                                    <li><a class="dropdown-item"
                                            href="{{ route('profile.edit') }}">{{ __('Profile') }}</a></li>

                                    <!-- Logout Form -->
                                    <li>
                                        <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                            @csrf
                                            <button type="submit" class="dropdown-item">{{ __('Log Out') }}</button>
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                @yield('content')
            </div>

        </div>

    </div>
     <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
