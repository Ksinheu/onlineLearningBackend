{{-- <div wire:poll.5s>
    @if ($newPayments->isNotEmpty())
        @foreach ($newPayments as $payment)
            <div class="alert alert-warning d-flex justify-content-between align-items-center">
                <div>
                    <strong>{{ $payment->customer->name }}</strong> submitted payment for 
                    <strong>{{ $payment->course->title }}</strong>.
                </div>
                <a href="{{ route('admin.payments') }}" class="btn btn-sm btn-primary">Review</a>
            </div>
        @endforeach
    @else
        <div class="alert alert-success">No new payments at the moment.</div>
    @endif
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
    window.addEventListener('new-payment-alert', () => {
        Swal.fire({
            title: '📢 New Payment Submitted!',
            text: 'A customer just submitted a payment. Click "Review" to check.',
            icon: 'info',
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3500,
            timerProgressBar: true,
            background: '#f0f9ff',
        });
    });
</script>

</div>
 --}}

<div >
    @if ( count($newPayments) > 0)
    <div style="background: blue; color:beige; position: absolute; top: 50%; left: 50%; transform: translate(-50%,-50%); z-index: 1000000;">
        @foreach ($newPayments as $payment)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ Str::limit($payment->customer->username, 5) }}</td>
                    <td>{{ Str::limit($payment->course->course_name, 10) }}</td>
                    <td>{{ $payment->course->price }}</td>
                    <td><span class="text-success">{{ $payment->payment_status }}</span></td>
                </tr>
        @endforeach
    </div>
    @endif
    {{-- @if (!empty($newPayments))
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>#</th>
                    <th>អតិថិជន</th>
                    <th>ទិញវគ្គសិក្សា</th>
                    <th>តម្លែ</th>
                    <th>ស្ថានភាព</th>
                </tr>
            </thead>

            <tbody>
                @foreach ($newPayments as $payment)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ Str::limit($payment->customer->username, 5) }}</td>
                        <td>{{ Str::limit($payment->course->course_name, 10) }}</td>
                        <td>{{ $payment->course->price }}</td>
                        <td><span class="text-success">{{ $payment->payment_status }}</span></td>
                    </tr>
                @endforeach
            </tbody>

        </table>
    @else
        <div class="alert alert-success">No new payments at the moment.</div>
    @endif --}}
{{-- 

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        window.addEventListener('new-payment-alert', event => {
            const customer = event.detail.customer;
            const course = event.detail.course;

            Swal.fire({
                title: '📢 New Payment Submitted!',
                html: `<strong>${customer}</strong> has submitted payment for <strong>${course}</strong>.`,
                icon: 'info',
                showCancelButton: true,
                confirmButtonText: 'Go to Review',
                cancelButtonText: 'Close',
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = "{{ route('admin.payments') }}";
                }
            });
        });
    </script> --}}
