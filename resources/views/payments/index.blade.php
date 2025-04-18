<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payments</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-6">

    <div class="max-w-4xl mx-auto bg-white p-6 shadow-md rounded-lg">
        <h2 class="text-2xl font-semibold mb-4">Payment Records</h2>

        <table class="w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="p-2 border">Course</th>
                    <th class="p-2 border">Purchase Date</th>
                    <th class="p-2 border">Status</th>
                    <th class="p-2 border">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($payments as $payment)
                    <tr class="text-center {{ $payment->payment_status == 'completed' ? 'bg-green-100' : ($payment->payment_status == 'failed' ? 'bg-red-100' : 'bg-yellow-100') }}">
                        <td class="p-2 border">{{ $payment->course->title }}</td>
                        <td class="p-2 border">{{ $payment->purchase_date }}</td>
                        <td class="p-2 border font-bold">{{ ucfirst($payment->payment_status) }}</td>
                        <td class="p-2 border">
                            @if($payment->payment_status == 'pending')
                                <form action="{{ route('payments.update', $payment->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="payment_status" value="completed">
                                    <button class="bg-blue-500 text-white px-3 py-1 rounded text-sm">Mark as Completed</button>
                                </form>
                            @endif
                            <form action="{{ route('payments.delete', $payment->id) }}" method="POST" class="inline">
                                @csrf
                                @method('DELETE')
                                <button class="bg-red-500 text-white px-3 py-1 rounded text-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

</body>
</html>
