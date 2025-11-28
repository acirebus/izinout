<nav class="fixed top-0 left-0 right-0 bg-white/95 backdrop-blur-sm border-b border-gray-200 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <a href="{{ route('landing') }}" class="flex items-center gap-2">
                <img src="https://cdn.builder.io/api/v1/image/assets%2Fe64a5e03458d49e8a674c2d1b43e24e2%2F08f5bf7c5ab04a6eac4d4d452607048f" alt="Logo Samping" class="w-8 h-8 mr-2 rounded-lg shadow" />
                <div class="w-10 h-10 bg-blue-600 rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                    </svg>
                </div>
                <span class="text-xl font-medium text-gray-900">IzinOut</span>
            </a>
            <div class="flex items-center gap-4">
                @auth
                    <a href="{{ auth()->user()->isAdmin() ? route('admin.dashboard') : route('student.dashboard') }}" 
                       class="inline-flex items-center px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                        Dashboard
                    </a>
                @else
                    <a href="{{ route('login') }}" 
                       class="inline-flex items-center px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-lg transition-colors">
                        Masuk
                    </a>
                @endauth
            </div>
        </div>
    </div>
</nav>
