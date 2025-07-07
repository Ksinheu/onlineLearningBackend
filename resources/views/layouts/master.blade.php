<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="description" />
    <meta name="author" content="author" />
    <meta name="keywords" content="keywords" />
    <title>Pccacademy</title>
    <link rel="shortcut icon" href="{{ asset('images/2.png') }}" type="image/png" />
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css"
        integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{asset('css/bootstrap.css')}}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @yield('link_style')
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <div class=" sidebar position-fixed" style="width: 240px; height: 100vh;">
                <div class="logo-details">
                    <img src="{{ asset('images/pcc-logo.png') }}" alt="">
                    {{-- <span class="logo_name">PCC</span> --}}
                </div>
                <ul class="navlinks">
                    <li>
                        <a href="{{ route('dashboard') }}" class="{{ Request::routeIs('dashboard') ? 'active' : '' }}">
                            <i class="fa-solid fa-house"></i>
                            <span class="links_name">ទំព័រដើម</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('course.index') }}"
                            class="{{ Request::routeIs('course.index') ? 'active' : '' }}">
                            <i class="fa-solid fa-book"></i>
                            <span class="links_name">មុខវិជ្ជា</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('lession.index') }}"
                            class="{{ Request::routeIs('lession.index') ? 'active' : '' }}">
                            <i class="fa-solid fa-book-open-reader"></i>
                            <span class="links_name">មេរៀន</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('content.index') }}"
                            class="{{ Request::routeIs('content.index') ? 'active' : '' }}">
                            <i class="fa-solid fa-bookmark"></i>
                            <span class="links_name">មាតិកាមេរៀន</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('exercise.index') }}"
                            class="{{ Request::routeIs('exercise.index') ? 'active' : '' }}">
                            <i class="fa-solid fa-file"></i>
                            <span class="links_name">លំហាត់</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('payment.index') }}"
                            class="{{ Request::routeIs('payment.index') ? 'active' : '' }}">
                            <i class="fa-solid fa-money-bill"></i>
                            <span class="links_name">ការទូទាត់</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{route('comments.index')}}"
                            class="{{ Request::routeIs('comments.index') ? 'active' : '' }}">
                            <i class="fa-solid fa-envelope"></i>
                            <span class="links_name">មតិយោបល់សិស្ស</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('payment_method.index') }}"
                            class="{{ Request::routeIs('payment_method.index') ? 'active' : '' }}">
                            <i class="fa-solid fa-credit-card"></i>
                            <span class="links_name">ប្រភេទធនាគារ</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('slider.index') }}"
                            class="{{ Request::routeIs('slider.index') ? 'active' : '' }}">
                            <i class="fa-solid fa-sliders"></i>
                            <span class="links_name">ស្លាយ</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('news.index') }}"
                            class="{{ Request::routeIs('news.index') ? 'active' : '' }}">
                            <i class="fa-solid fa-newspaper"></i>
                            <span class="links_name">ព័ត៌មាន</span>
                        </a>
                    </li>

                    <li class="log_out">
                        <a href="#">
                            <i class='bx bx-log-out'></i>
                            <span class="links_name">
                                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                    @csrf
                                    <button type="submit" class="dropdown-item">{{ __('ចេញ') }}</button>
                                </form>
                            </span>
                        </a>
                    </li>
                </ul>

            </div>
            <div class="col-10 home-section">
                <nav>
                    <div class="sidebar-button">
                        <i class='bx bx-menu sidebarBtn'></i>
                        {{-- <span class="dashboard">@yield('page-title', 'ទំព័រដើម')</span> --}}
                        <span class="dashboard">
                            @php
                                $routeName = Route::currentRouteName();
                                $routePrefix = explode('.', $routeName)[0];
                            @endphp

                            @switch($routePrefix)
                                @case('dashboard')
                                    ទំព័រដើម
                                @break

                                @case('course')
                                    មុខវិជ្ជា
                                @break

                                @case('lession')
                                    មេរៀន
                                @break

                                @case('content')
                                    មាតិកាមេរៀន
                                @break

                                @case('payment')
                                    ទូទាត់
                                @break
                                @case('comments')
                                    មតិយោបល់សិស្ស
                                @break
                                @case('exercise')
                                    លំហាត់
                                @break

                                @case('payment_method')
                                    ប្រភេទធនាគារ
                                @break

                                @case('slider')
                                    ស្លាយ
                                @break

                                @case('news')
                                    ព័ត៌មាន
                                @break

                                @default
                                    ទំព័រដើម
                            @endswitch
                        </span>
                    </div>
                  
                    <div class="profile-details">
                        <img src="{{ asset('images/3135715.png') }}" alt="">
                        <span class="admin_name"> {{ Auth::user()->name }}
                        </span>
                        {{-- <i class='bx bx-chevron-down ' type="button" id="userDropdown"
            data-bs-toggle="dropdown" aria-expanded="false" ></i>
            <ul class="dropdown-menu" aria-labelledby="userDropdown">
              <!-- Profile Link -->
              <li><a class="dropdown-item"
                      href="{{ route('profile.edit') }}">{{ __('Profile') }}</a></li> --}}
                        </ul>
                    </div>
                </nav>
                @yield('content')
            </div>

        </div>
        <footer  class="footer bg-white border-top text-center text-muted small py-2" style="margin-left: 16.666667%;">
  <div class="container">
    <span>&copy; 2025 Online Learning System | Version 1.0.0</span>
  </div>
</footer>
    </div>
    {{-- <livewire:payment /> --}}
    <script src="{{asset('js/bootstrap.js')}}"></script>
    {{-- @livewire('admin-payment-alerts') --}}
    @livewireScripts
    {{-- @push('scripts')
    <script>
        window.addEventListener('playNotificationSound', () => {
            const sound = document.getElementById('notifySound');
            if (sound) {
                sound.play().catch(err => {
                    console.warn('Autoplay prevented by browser:', err);
                });
            }
        });
    </script>
    @endpush --}}
</body>
@yield('script')
<script src="{{asset('js/function.js')}}"></script>
</html>
