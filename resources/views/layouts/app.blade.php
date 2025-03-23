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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
            @import url('https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Suwannaphum:wght@100;300;400;700;900&display=swap');
*{
    font-family: "Suwannaphum", serif;
}
        .bg-Blue {
            background-color: #080c79;

        }

        .bg-darkBlue {
            background-color: #2e3190;

        }
        .sidebar{
            position: fixed;
            top: 0;
            left: 0;
            height: 100%;
            width: 265px;
            padding-top: 20px;
            background-color: #080c79;
            transition: width 0.3s;
        }
        .sidebar .nav-link{
            display: flex;
            align-items: center;
            gap: 20px;
            padding: 10px 40px ;
            color: #fff;
        }
        .sidebar .description{
            font-size: 14px;
        }
        .sidebar .nav-link:hover{
            background-color: #d8a602
        }
        @media(max-width: 480px){
            .sidebar{
                width: 60px;
            }
            .sidebar .description{
                display: none;
            }
            .sidebar .nav-link{
                justify-content: center;
            }
        }
        
    </style>
</head>

<body class="bg-secondary-subtle">
    {{-- <div class="min-h-screen bg-gray-100 dark:bg-gray-900">
            @include('layouts.navigation')

            
            @if (isset($header))
                <header class="bg-white dark:bg-gray-800 shadow">
                    <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endif
            <main>
                {{ $slot }}
            </main>
        </div> --}}
    <div class="container-fluid">
        
        <div class="row">
        
            <!-- Sidebar -->
            <div class="col-2"
                style="box-shadow: rgba(0, 0, 0, 0.15) 2.4px 2.4px 3.2px;">
                {{-- <h5 class="pt-4"></h5> --}}
                {{-- <ul class="list-group list-group-flush">
                    <li class="list-group-item bg-darkBlue"><a href="#"
                            class="text-white text-decoration-none">Home</a></li>
                    <li class="list-group-item bg-darkBlue"><a href="{{route('slider.index')}}"
                            class="text-white text-decoration-none" {{ Request::routeIs('slider.index') ? 'active' : '' }}>Slider</a></li>
                    <li class="list-group-item bg-darkBlue"><a href="{{route('news.index')}}"
                            class="text-white text-decoration-none" {{ Request::routeIs('news.index') ? 'active' : '' }}>News</a></li>
                    <li class="list-group-item bg-darkBlue"><a href="#"
                            class="text-white text-decoration-none">Contact</a></li>
                </ul> --}}
                <div class="sidebar">
                    
                    <nav class="nav flex-column">
                        <a href="" class="mb-4 ">
                            <div>
                                <img src="{{ asset('images/pcc-logo.png') }}" alt="" class="w-100">
                            </div>
                        </a>
                        <a href="{{route('dashboard')}}" class="nav-link">
                            <span class="icon"><i class="fa-solid fa-gauge"></i></span>
                            <span class="description">Dashboard</span>
                        </a>
                        <a href="{{route('course.index')}}" class="nav-link"  {{ Request::routeIs('course.index') ? 'active' : '' }}>
                            <span class="icon"><i class="fa-solid fa-list"></i></span>
                            <span class="description">Course</span>
                        </a>
                        <a href="{{route('lession.index')}}" class="nav-link" {{ Request::routeIs('lession.index') ? 'active' : '' }}>
                            <span class="icon"><i class="fa-solid fa-film"></i></span>
                            <span class="description">Lesson</span>
                        </a>
                        <a href="" class="nav-link">
                            <span class="icon"></span>
                            <span class="description">Assignment</span>
                        </a>
                        <a href="" class="nav-link">
                            <span class="icon"></span>
                            <span class="description">Payment</span>
                        </a>
                        <a href="" class="nav-link">
                            <span class="icon"></span>
                            <span class="description">Notification</span>
                        </a>
                        <a href="" class="nav-link"  data-bs-target="#submenu"  aria-controls="submenu"  data-bs-toggle="collapse" href="#collapseExample" role="button" aria-expanded="false" >
                            <span class="icon"></span>
                            <span class="description">Setting</span>
                        </a>
                        
                        <div class="sub-menu collapse" id="submenu">
                            
                            <a href="{{route('slider.index')}}" class="nav-link" {{ Request::routeIs('slider.index') ? 'active' : '' }}>
                                <span class="icon">
                                </span>
                                <span class="description">Slider</span>
                            </a>
                            <a href="{{route('news.index')}}" class="nav-link" {{ Request::routeIs('news.index') ? 'active' : '' }}>
                                <span class="icon">

                                </span>
                                <span class="description">News</span>
                            </a>
                        </div>
                    </nav>
                </div>
            </div>
        
            <div class="col-10 offset-2">
                <div class="row bg-white mb-3 shadow ">
                    <div class="col-10"></div>
                    <div class="col-2 text-center p-3 ">
                        <!-- User Dropdown -->
                        <div class="dropdown justify-content-end">
                            <button class="btn btn-outline-success dropdown-toggle" type="button" id="userDropdown"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                {{ Auth::user()->name }}
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="userDropdown">
                                <!-- Profile Link -->
                                <li><a class="dropdown-item" href="{{ route('profile.edit') }}">{{ __('Profile') }}</a></li>
        
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
                @yield('content')
            </div>
        </div>
        
    </div>
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script> --}}
   
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
