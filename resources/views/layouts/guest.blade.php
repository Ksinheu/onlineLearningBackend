<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Pccacademy') }}</title>
        <link rel="stylesheet" href="{{asset('/css/login.css')}}">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
        {{-- <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script> --}}
        <style>
            /* Googlefont Poppins CDN Link */
@import url('https://fonts.googleapis.com/css2?family=Battambang:wght@100;300;400;700;900&family=Kantumruy+Pro:ital@0;1&family=Open+Sans:ital,wght@0,300..800;1,300..800&family=Suwannaphum:wght@100;300;400;700;900&display=swap');
*{
 font-family:"Suwannaphum", serif;
}
        </style>
        {{-- @vite(['resources/css/app.css', 'resources/js/app.js']) --}}
    </head>
    <body class="bg-gray">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 ">
@yield('content')
                </div>
            </div>
        </div>
    
            {{-- {{ $slot }} --}}
       
    {{-- <script src="https://unpkg.com/@tailwindcss/browser@4"></script> --}}
</body>

</html>
