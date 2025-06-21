<!-- Notification Badge -->
<div class="position-relative">
    @if(count($notifications) > 0)
        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
            {{ count($notifications) }}
        </span>
    @endif
</div>

<!-- Notification Dropdown -->
<div class="dropdown">
    <button class="btn btn-secondary dropdown-toggle" type="button" id="notificationDropdown" data-bs-toggle="dropdown" aria-expanded="false">
        Notifications
    </button>
    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationDropdown" style="width: 300px;">
        @if(count($notifications) > 0)
            @foreach($notifications as $key => $notification)
                <li class="border-bottom">
                    <div class="dropdown-item d-flex align-items-center">
                        <div class="flex-grow-1">
                            <strong>{{ $notification['customer'] }}</strong> has made a new payment
                            <small class="text-muted">{{ $notification['time'] }}</small>
                        </div>
                        <button wire:click="markAsRead('{{ $key }}')" class="btn btn-sm btn-danger ms-2">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                </li>
            @endforeach
            <li class="dropdown-item text-center">
                <button wire:click="markAllAsRead" class="btn btn-sm btn-secondary">
                    Mark all as read
                </button>
            </li>
        @else
            <li class="dropdown-item text-center">
                No new notifications
            </li>
        @endif
    </ul>
</div>

@push('scripts')
<script>
    window.addEventListener('newPayment', event => {
        // Refresh the notification component
        @this.$refresh();
    });
</script>
@endpush
