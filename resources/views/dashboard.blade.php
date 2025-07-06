@extends('layouts.master')
@section('link_style')
@livewireStyles
<link rel="stylesheet" href="{{asset('css/main.css')}}">
<link rel="stylesheet" href="{{asset('css/popup.css')}}">
@endsection
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
                <div class="number">{{ $countAll }}</div><span> នាក់</span>
                <div class="indicator">
                    <i class='bx bx-up-arrow-alt'></i>
                    <span class="text">ថ្ងៃនេះ</span>
                </div>
            </div>
            <i class='bx bx-user cart two'></i>
        </div>
        <div class="box">
            <div class="right-side">
                <div class="box-topic">ចំណូលសរុប</div>
                <div class="number">{{ $totalIncome }} $</div>
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
                <div class="number">{{ $paidStudentCount }}</div> <span> នាក់</span>
                <div class="indicator">
                    <i class='bx bx-up-arrow-alt'></i>
                    <span class="text">ថ្ងៃនេះ</span>
                </div>
            </div>
            <i class='bx bxs-cart-download cart four'></i>
        </div>
    </div>

    <div class="sales-boxes">
        <div class="recent-sales box">
            <div class="title">សិស្សបានចុះឈ្មោះ</div>
            <div class="sales-details">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>ឈ្មោះ</th>
                            <th>Email</th>
                            <th>ភេទ</th>
                            <th>លេខទូរស័ព្ទ</th>
                            <th>សកម្មភាព</th>
                        </tr>
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
            <div class="button">
                <a href="#">See All</a>
            </div>
        </div>
        <div class="top-sales box">
            <div class="title">ការទូទាត់</div>
            <livewire:payment />
        </div>
    </div>
</div>

@endsection
@section('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @livewireScripts
    @stack('scripts')
    <script>
    window.addEventListener('playNotificationSound', () => {
        const audio = new Audio('{{asset('sounds/notify.ogg')}}');
        audio.play().catch(e => {
            console.warn('Sound playback failed:', e);
        });
    });
</script>

@endsection

