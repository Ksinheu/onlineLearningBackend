
@extends('layouts.master')

@section('content')
  <nav>
    <div class="sidebar-button">
      <i class='bx bx-menu sidebarBtn'></i>
      <span class="dashboard">Dashboard</span>
    </div>
    <div class="search-box">
      <input type="text" placeholder="Search...">
      <i class='bx bx-search' ></i>
    </div>
    <div class="profile-details">
      {{-- <img src="images/profile.jpg" alt=""> --}}
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
  <div class="home-content">
    <div class="overview-boxes">
      <div class="box">
        <div class="right-side">
          <div class="box-topic">Total Order</div>
          <div class="number">40,876</div>
          <div class="indicator">
            <i class='bx bx-up-arrow-alt'></i>
            <span class="text">Up from yesterday</span>
          </div>
        </div>
        <i class='bx bx-cart-alt cart'></i>
      </div>
      <div class="box">
        <div class="right-side">
          <div class="box-topic">Total Sales</div>
          <div class="number">38,876</div>
          <div class="indicator">
            <i class='bx bx-up-arrow-alt'></i>
            <span class="text">Up from yesterday</span>
          </div>
        </div>
        <i class='bx bxs-cart-add cart two' ></i>
      </div>
      <div class="box">
        <div class="right-side">
          <div class="box-topic">Total Profit</div>
          <div class="number">$12,876</div>
          <div class="indicator">
            <i class='bx bx-up-arrow-alt'></i>
            <span class="text">Up from yesterday</span>
          </div>
        </div>
        <i class='bx bx-cart cart three' ></i>
      </div>
      <div class="box">
        <div class="right-side">
          <div class="box-topic">Total Return</div>
          <div class="number">11,086</div>
          <div class="indicator">
            <i class='bx bx-down-arrow-alt down'></i>
            <span class="text">Down From Today</span>
          </div>
        </div>
        <i class='bx bxs-cart-download cart four' ></i>
      </div>
    </div>
    <div class="sales-boxes">
      <div class="recent-sales box">
        <div class="title">Recent Sales</div>
        <div class="sales-details">
          {{-- <ul class="details"> --}}
            <table class="table  table-striped">
              <thead>
                <th>ID</th>
                <th>Username</th>
                <th>Email</th>
                <th>Gender</th>
                <th>Phone Number</th>
                <th>Status</th>
              </thead>
              <tbody>
                @foreach($customers as $customer)
                <tr>
                    <td>{{ $customer->id }}</td>
                    <td>{{ $customer->username }}</td>
                    <td>{{ $customer->email }}</td>
                    <td>{{ $customer->gender }}</td>
                    <td>{{ $customer->phone }}</td>
                    <td>{{ $customer->status }}</td>
                </tr>
                @endforeach
              </tbody>
            </table>
          {{-- </ul> --}}
        </div>
        <div class="button">
          <a href="#">See All</a>
        </div>
      </div>
      <div class="top-sales box">
        <div class="title">Top Seling Product</div>
        
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
@endsection
