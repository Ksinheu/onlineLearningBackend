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
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="dist/output.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
    <style>
        .bg-Blue {
            background-color: #080c79;

        }

        .bg-darkBlue {
            background-color: #2e3190;

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
        <div class="row bg-Blue p-2 shadow"
            style="box-shadow: rgba(50, 50, 93, 0.25) 0px 6px 12px -2px, rgba(0, 0, 0, 0.3) 0px 3px 7px -3px;z-index: 999999999;">
            <div class="col-1"></div>
            <div class="col-3">
                <div>
                    <img src="{{ asset('images/pcc-logo.png') }}" alt="" class="w-100">
                </div>
            </div>
            <div class="col-6"></div>
            <div class="col-2 text-center pt-4">
                <!-- User Dropdown -->
                <div class="dropdown">
                    <button class="btn btn-outline-light dropdown-toggle" type="button" id="userDropdown"
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
        <div class="row">
        
            <!-- Sidebar -->
            <div class="col-2 bg-darkBlue text-white vh-100 position-fixed"
                style="box-shadow: rgba(0, 0, 0, 0.15) 2.4px 2.4px 3.2px;">
                <h5 class="pt-4"></h5>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item bg-darkBlue"><a href="#"
                            class="text-white text-decoration-none">Home</a></li>
                    <li class="list-group-item bg-darkBlue"><a href="{{route('sliders')}}"
                            class="text-white text-decoration-none">Slider</a></li>
                    <li class="list-group-item bg-darkBlue"><a href="#"
                            class="text-white text-decoration-none">News</a></li>
                    <li class="list-group-item bg-darkBlue"><a href="#"
                            class="text-white text-decoration-none">Contact</a></li>
                </ul>
            </div>
        
            <div class="col-10 offset-2 pt-3">
                @yield('content')
            </div>
        </div>
        
    </div>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
</body>

</html>
