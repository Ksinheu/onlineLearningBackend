<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
     <meta name="description" content="description"/>
    <meta name="author" content="author" />
    <meta name="keywords" content="keywords" />
    <title>Document</title>
    <link rel="shortcut icon" href="{{ asset('images/pcc-logo.png') }}" type="image/png" />
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
  <div class="container-fluid">
    <div class="row">
    <div class="col-2 sidebar position-fixed">
        <div class="logo-details">
            <img src="{{ asset('images/pcc-logo.png') }}" alt="">
          {{-- <span class="logo_name">PCC</span> --}}
        </div>
        <ul class="navlinks">
          <li>
            <a href="{{ route('dashboard') }}" class="{{ Request::routeIs('dashboard') ? 'active' : '' }}">
              <i class='bx bx-grid-alt' ></i>
              <span class="links_name">ទំព័រដើម</span>
            </a>
          </li>
          <li>
            <a href="{{ route('course.index') }}" class="{{ Request::routeIs('course.index') ? 'active' : '' }}">
              <i class='bx bx-box' ></i>
              <span class="links_name">មុខវិជ្ជា</span>
            </a>
          </li>
          <li>
            <a href="{{ route('lession.index') }}" class="{{ Request::routeIs('lession.index') ? 'active' : '' }}">
              <i class='bx bx-list-ul' ></i>
              <span class="links_name">មេរៀន</span>
            </a>
          </li>
          <li>
            <a href="{{route('exercise.index')}}"  class="{{ Request::routeIs('exercise.index') ? 'active' : '' }}">
              <i class='bx bx-cog' ></i>
              <span class="links_name">លំហាត់</span>
            </a>
          </li>
          <li>
            <a href="{{ route('assignment.index') }}" class="{{ Request::routeIs('assignment.index') ? 'active' : '' }}">
              <i class='bx bx-pie-chart-alt-2' ></i>
              <span class="links_name">Assignment</span>
            </a>
          </li>
          <li>
            <a href="{{ route('notification.index') }}" class="{{ Request::routeIs('notification.index') ? 'active' : '' }}">
              <i class='bx bx-coin-stack' ></i>
              <span class="links_name">Notification</span>
            </a>
          </li>
          <li>
            <a href="{{ route('payment.index') }}" class="{{ Request::routeIs('payment.index') ? 'active' : '' }}">
              <i class='bx bx-book-alt' ></i>
              <span class="links_name">ការទូទាត់</span>
            </a>
          </li>
          <li>
            <a href="{{ route('payment_method.index') }}" class="{{ Request::routeIs('payment_method.index') ? 'active' : '' }}">
              <i class='bx bx-book-alt' ></i>
              <span class="links_name">វិធីសាស្រ្តទូទាត់</span>
            </a>
          </li>
          <li>
            <a href="#">
              <i class='bx bx-user' ></i>
              <span class="links_name">Reviews</span>
            </a>
          </li>
          <li>
            <a href="{{ route('slider.index') }}"  class="{{ Request::routeIs('slider.index') ? 'active' : '' }}">
              <i class='bx bx-message' ></i>
              <span class="links_name">ស្លាយ</span>
            </a>
          </li>
          <li>
            <a href="{{ route('news.index') }}"  class="{{ Request::routeIs('news.index') ? 'active' : '' }}">
              <i class='bx bx-heart' ></i>
              <span class="links_name">ព័ត៌មាន</span>
            </a>
          </li>
          
          <li class="log_out">
            <a href="#">
              <i class='bx bx-log-out'></i>
              <span class="links_name"><form method="POST" action="{{ route('logout') }}" class="d-inline">
                @csrf
                <button type="submit" class="dropdown-item">{{ __('ចេញ') }}</button>
            </form></span>
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
    @case('exercise')
        លំហាត់
        @break
    @case('payment_method')
        វិធីសាស្រ្ដទូទាត់
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
          {{-- <div class="search-box">
            <input type="text" placeholder="Search...">
            <i class='bx bx-search' ></i>
          </div> --}}
          <div class="profile-details">
            <img src="{{asset('images/3135715.png')}}" alt="">
            <span class="admin_name"> {{ Auth::user()->name }}               
            </span>
            <i class='bx bx-chevron-down ' type="button" id="userDropdown"
            data-bs-toggle="dropdown" aria-expanded="false" ></i>
            <ul class="dropdown-menu" aria-labelledby="userDropdown">
              <!-- Profile Link -->
              <li><a class="dropdown-item"
                      href="{{ route('profile.edit') }}">{{ __('Profile') }}</a></li>
          </ul>
          </div>
        </nav>
        @yield('content')
      </div>
    </div>
  </div>
  <script>
    let sidebar = document.querySelector(".sidebar");
   let sidebarBtn = document.querySelector(".sidebarBtn");
   sidebarBtn.onclick = function() {
   sidebar.classList.toggle("active");
   if(sidebar.classList.contains("active")){
   sidebarBtn.classList.replace("bx-menu" ,"bx-menu-alt-right");
   }else
   sidebarBtn.classList.replace("bx-menu-alt-right", "bx-menu");
   }
   </script>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
  </script>
</body>
</html>