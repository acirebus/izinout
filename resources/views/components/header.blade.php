@props(['user', 'title' => 'Dashboard'])

<header class="bg-white shadow-sm border-b border-gray-200">
    <div class="px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center py-4">
            <!-- Mobile menu button -->
            <div class="flex items-center lg:hidden">
                <button type="button" 
                        class="p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                        @click="sidebarOpen = !sidebarOpen">
                    <i class="fas fa-bars text-lg"></i>
                </button>
                <h1 class="ml-3 text-xl font-semibold text-gray-900">{{ $title }}</h1>
            </div>

            <!-- Desktop title -->
            <div class="hidden lg:block">
                <h1 class="text-2xl font-semibold text-gray-900">{{ $title }}</h1>
            </div>

            <!-- User menu -->
            <div class="flex items-center space-x-4">
                <!-- Notifications -->
                @php
                    // Ambil notifikasi sesuai role
                    if ($user->role === 'guru') {
                        $notifications = $user->notifications()->orderBy('created_at', 'desc')->take(20)->get();
                    } else {
                        $notifications = \App\Models\Notification::where('user_id', $user->user_id)
                            ->orderBy('created_at', 'desc')
                            ->take(10)
                            ->get();
                    }
                @endphp
                <x-notifications :notifications="$notifications" />

                <!-- Profile dropdown -->
                <div class="relative" x-data="{ open: false }">
                    <button type="button" 
                            class="flex items-center text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-blue-500"
                            @click="open = !open">
                        <div class="h-8 w-8 bg-blue-100 rounded-full flex items-center justify-center">
                            <i class="fas {{ $user->role === 'admin' ? 'fa-user-tie' : 'fa-user-graduate' }} text-blue-600 text-sm"></i>
                        </div>
                        <span class="ml-2 text-gray-700 font-medium hidden sm:block">{{ $user->name }}</span>
                        <i class="fas fa-chevron-down ml-2 text-gray-400 text-xs hidden sm:block"></i>
                    </button>

                    <!-- Dropdown menu -->
                    <div x-show="open" 
                         @click.outside="open = false"
                         x-transition
                         class="absolute right-0 mt-2 w-48 bg-white rounded-lg shadow-lg border border-gray-200 z-50">
                        <div class="py-2">
                            <div class="px-4 py-2 border-b border-gray-100">
                                <p class="text-sm font-medium text-gray-900">{{ $user->name }}</p>
                                <p class="text-xs text-gray-500">{{ $user->email }}</p>
                            </div>
                            
                            <a href="
                                @if($user->role === 'admin_bk')
                                    {{ route('admin.profile') }}
                                @elseif($user->role === 'guru')
                                    {{ route('guru.profile') }}
                                @else
                                    {{ route('student.profile') }}
                                @endif
                                " 
                               class="flex items-center px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                <i class="fas fa-user mr-3 w-4"></i>
                                Profile Saya
                            </a>
                            
                            <div class="border-t border-gray-100 mt-2 pt-2">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" 
                                            class="flex items-center w-full px-4 py-2 text-sm text-red-600 hover:bg-red-50">
                                        <i class="fas fa-sign-out-alt mr-3 w-4"></i>
                                        Logout
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>