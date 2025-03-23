@extends('layouts.app')
@section('content')
    {{-- <h1>{{ __('Dashboard') }}</h1> --}}

            <!-- Main Content -->
            <div class="col-12 ">
              <div class="row">
                <div class="col-4">
                  <div class="card p-5 bg-primary">
                    User Login
                  </div>
                </div>
                <div class="col-4">
                  <div class="card p-5 bg-success">
                    User Buy Lession
                  </div>
                </div>
                <div class="col-4">
                  <div class="card p-5 bg-danger">
                    Lession Upload
                  </div>
                </div>
              </div>
              {{-- Table Customer --}}
              <div class="row mt-4">
                <div class="col-12">
                  <div class="card p-4">
                    <table class="table table-secondary table-striped">
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
                  </div>
                </div>
              </div>
         
@endsection
