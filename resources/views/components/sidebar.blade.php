@props(['user', 'role', 'activeTab' => 'dashboard'])

<div class="bg-white shadow-sm border-r border-gray-200 h-full">
    <!-- Header -->
    <div class="px-6 py-6 border-b border-gray-200">
        <div class="flex items-center">
            <div class="h-8 w-8 bg-blue-600 rounded-full flex items-center justify-center">
                <i class="fas fa-user-graduate text-white text-sm"></i>
            </div>
            <h1 class="ml-3 text-lg font-bold text-gray-900">IzinOut</h1>
        </div>
    </div>

    <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
        <div class="flex items-center">
            <div class="h-10 w-10 bg-blue-100 rounded-full flex items-center justify-center">
                <i class="fas {{ $role === 'admin_bk' ? 'fa-user-tie' : 'fa-user-graduate' }} text-blue-600"></i>
            </div>
            <div class="ml-3 min-w-0 flex-1">
                <p class="text-sm font-medium text-gray-900 truncate">{{ $user->name }}</p>
                <p class="text-xs text-gray-500 truncate">{{ ucfirst($user->role) }}</p>
                <p class="text-xs text-blue-600 truncate">{{ $user->school->name }}</p>
            </div>
        </div>
    </div>

    <nav class="px-3 py-4 space-y-1">
    @if($role === 'admin_bk')
        <a href="{{ route('admin.dashboard') }}"
           class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ $activeTab === 'dashboard' ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}">
            <i class="fas fa-chart-pie w-5 mr-3"></i>
            <span>Dashboard</span>
        </a>
        <a href="{{ route('admin.permissions') }}"
           class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ $activeTab === 'permissions' ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}">
            <i class="fas fa-clipboard-list w-5 mr-3"></i>
            <span>Perizinan</span>
        </a>
        <a href="{{ route('admin.students') }}"
           class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ $activeTab === 'students' ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}">
            <i class="fas fa-users w-5 mr-3"></i>
            <span>Data Siswa</span>
        </a>
        <a href="{{ route('admin.users') }}"
           class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ $activeTab === 'users' ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}">
            <i class="fas fa-user-cog w-5 mr-3"></i>
            <span>Data Pengguna</span>
        </a>
    @elseif($role === 'student')
        <a href="{{ route('student.dashboard') }}"
           class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ $activeTab === 'dashboard' ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}">
            <i class="fas fa-home w-5 mr-3"></i>
            <span>Dashboard</span>
        </a>
        <a href="{{ route('student.permission.create') }}"
           class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ $activeTab === 'create' ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}">
            <i class="fas fa-plus-circle w-5 mr-3"></i>
            <span>Ajukan Izin</span>
        </a>
        <a href="{{ route('student.permissions') }}"
           class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ $activeTab === 'permissions' ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}">
            <i class="fas fa-list-alt w-5 mr-3"></i>
            <span>Riwayat Izin</span>
        </a>
    @elseif($role === 'guru')
        <a href="{{ route('guru.dashboard') }}"
           class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ $activeTab === 'dashboard' ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}">
            <i class="fas fa-home w-5 mr-3"></i>
            <span>Dashboard</span>
        </a>
        <a href="{{ route('guru.riwayatizin') }}"
           class="flex items-center px-3 py-2 text-sm font-medium rounded-lg transition-colors {{ $activeTab === 'riwayatizin' ? 'bg-blue-600 text-white' : 'text-gray-700 hover:bg-gray-100 hover:text-gray-900' }}">
            <i class="fas fa-history w-5 mr-3"></i>
            <span>Riwayat Izin Siswa</span>
        </a>
    @endif
    </nav>

    <div class="absolute bottom-4 left-0 right-0 px-6">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
        <button type="submit" 
            class="w-500 flex items-center px-3 py-2 text-sm font-medium text-red-600 hover:bg-red-100 rounded-lg transition duration-150 ease-in-out focus:outline-none">
                <i class="fas fa-sign-out-alt w-5 mr-3"></i>
                <span>Logout</span>
            </button>
        </form>
    </div>
</div>