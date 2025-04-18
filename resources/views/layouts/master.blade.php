<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    <link href='https://unpkg.com/boxicons@2.0.7/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>
<body>
    <div class="col-2 sidebar">
        <div class="logo-details">
            <img src="{{ asset('images/pcc-logo.png') }}" alt="">
          {{-- <span class="logo_name">PCC</span> --}}
        </div>
          <ul class="navlinks">
            <li>
              <a href="{{ route('dashboard') }}" class="{{ Request::routeIs('dashboard') ? 'active' : '' }}">
                <i class='bx bx-grid-alt' ></i>
                <span class="links_name">Dashboard</span>
              </a>
            </li>
            <li>
              <a href="{{ route('course.index') }}" class="{{ Request::routeIs('course.index') ? 'active' : '' }}">
                <i class='bx bx-box' ></i>
                <span class="links_name">Course</span>
              </a>
            </li>
            <li>
              <a href="{{ route('lession.index') }}" class="{{ Request::routeIs('lession.index') ? 'active' : '' }}">
                <i class='bx bx-list-ul' ></i>
                <span class="links_name">Lesson</span>
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
              <a href="#">
                <i class='bx bx-book-alt' ></i>
                <span class="links_name">Payment</span>
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
                <span class="links_name">slider</span>
              </a>
            </li>
            <li>
              <a href="{{ route('news.index') }}"  class="{{ Request::routeIs('news.index') ? 'active' : '' }}">
                <i class='bx bx-heart' ></i>
                <span class="links_name">News</span>
              </a>
            </li>
            <li>
              <a href="#">
                <i class='bx bx-cog' ></i>
                <span class="links_name">Setting</span>
              </a>
            </li>
            <li class="log_out">
              <a href="#">
                <i class='bx bx-log-out'></i>
                <span class="links_name"><form method="POST" action="{{ route('logout') }}" class="d-inline">
                  @csrf
                  <button type="submit" class="dropdown-item">{{ __('Log Out') }}</button>
              </form></span>
              </a>
            </li>
          </ul>
      </div>
      <section class="col-10 home-section">
        
        @yield('content')
      </section>
      <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
  </script>
</body>
</html>