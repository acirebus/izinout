@props(['notifications'])

<div class="relative">
    <button type="button" class="p-2 text-gray-400 hover:text-gray-500 hover:bg-gray-100 rounded-full transition-colors" id="notifBtn">
        <i class="fas fa-bell text-lg"></i>
        @if($notifications->where('status', 'unread')->count() > 0)
            <span class="absolute top-0 right-0 block h-2 w-2 rounded-full bg-red-500"></span>
        @endif
    </button>
    <!-- Dropdown -->
    <div id="notifDropdown" class="hidden absolute right-0 mt-2 w-80 bg-white rounded-lg shadow-lg border border-gray-200 z-50">
    <div class="py-2 max-h-96 overflow-y-auto">
            <div class="px-4 py-2 border-b border-gray-100 font-semibold text-gray-900">Notifikasi</div>
            @forelse($notifications as $notif)
                <div class="px-4 py-2 border-b border-gray-100 {{ $notif->isUnread() ? 'bg-blue-50' : '' }}">
                    <div class="flex justify-between items-center">
                        <div>
                            <p class="text-sm font-medium">{{ $notif->title }}</p>
                            <p class="text-xs text-gray-500">{{ $notif->message }}</p>
                            <p class="text-xs text-gray-400 mt-1">{{ $notif->formatted_created_at }}</p>
                        </div>
                        @if($notif->isUnread())
                            <form method="POST" action="{{ route('notification.read', $notif->notification_id) }}">
                                @csrf
                                <button type="submit" class="text-xs text-blue-600 hover:underline">Tandai dibaca</button>
                            </form>
                        @endif
                    </div>
                </div>
            @empty
                <div class="px-4 py-6 text-center text-gray-500">Tidak ada notifikasi</div>
            @endforelse
        </div>
    </div>
</div>
<script>
document.getElementById('notifBtn').addEventListener('click', function(e) {
    e.stopPropagation();
    var dropdown = document.getElementById('notifDropdown');
    dropdown.classList.toggle('hidden');
    // AJAX: tandai semua notifikasi unread sebagai read saat dropdown dibuka
    if (!dropdown.classList.contains('hidden')) {
        fetch("{{ route('notification.read', 'all') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
            },
        });
    }
});
document.addEventListener('click', function(e) {
    var dropdown = document.getElementById('notifDropdown');
    if (!dropdown.classList.contains('hidden')) {
        dropdown.classList.add('hidden');
    }
});
</script>
