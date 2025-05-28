
@extends('layouts.master')

@section('content')
  <div class="home-content">
    <div class="overview-boxes">
      <div class="box">
        <div class="right-side">
          <div class="box-topic">សិស្សចុះឈ្មោះថ្មី</div>
          <div class="number">{{ $count }}</div><span> នាក់</span>
          <div class="indicator">
            <i class='bx bx-up-arrow-alt'></i>
            <span class="text">ថ្ងៃនេះ</span>
          </div>
        </div>
        <i class='bx bx-user cart'></i>
      </div>
      <div class="box">
        <div class="right-side">
          <div class="box-topic">ចំនួនសិស្សបានចុះឈ្មោះ</div>
          <div class="number">{{$countAll}} </div><span> នាក់</span>
          <div class="indicator">
            <i class='bx bx-up-arrow-alt'></i>
            <span class="text">ថ្ងៃនេះ</span>
          </div>
        </div>
       <i class='bx bx-user cart two'></i>
      </div>
      <div class="box">
        <div class="right-side">
          <div class="box-topic">ចំណូល</div>
          <div class="number">$ </div>
          <div class="indicator">
            <i class='bx bx-up-arrow-alt'></i>
            <span class="text">ថ្ងៃនេះ</span>
          </div>
        </div>
        <i class='bx bx-money cart three'></i>
      </div>
      <div class="box">
        <div class="right-side">
          <div class="box-topic">ចំនួនសិស្សបានទិញមេរៀន</div>
          <div class="number">1</div> <span> នាក់</span>
          <div class="indicator">
            <i class='bx bx-up-arrow-alt'></i>
            <span class="text">ថ្ងៃនេះ</span>
          </div>
        </div>
        <i class='bx bxs-cart-download cart four' ></i>
      </div>
    </div>
    <div class="sales-boxes">
      <div class="recent-sales box">
        <div class="title">សិស្សបានចុះឈ្មោះ</div>
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
        <div class="title">ការទូទាត់</div>
        
      </div>
    </div>
  </div>

@endsection
