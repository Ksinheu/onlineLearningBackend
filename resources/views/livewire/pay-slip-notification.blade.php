
<div>
    @if ($message)
        <div class="bg-green-100 text-green-800 px-4 py-2 rounded shadow-md fixed top-5 right-5 z-50">
            {{ $message }}
        </div>

        <script>
            window.addEventListener('clear-notification', () => {
                setTimeout(() => {
                    Livewire.emit('resetMessage');
                }, 5000);
            });
        </script>
    @endif
     {{-- Table --}}
    
</div>

