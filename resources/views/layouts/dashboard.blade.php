@extends('layouts.app')

@section('content')
<div class="min-h-screen bg-gray-50" x-data="{ sidebarOpen: false }">
    <!-- Mobile sidebar overlay -->
    <div x-show="sidebarOpen" 
         @click="sidebarOpen = false"
         x-transition:enter="transition-opacity ease-linear duration-300"
         x-transition:enter-start="opacity-0"
         x-transition:enter-end="opacity-100"
         x-transition:leave="transition-opacity ease-linear duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0"
         class="fixed inset-0 z-50 lg:hidden">
        <div class="fixed inset-0 bg-black bg-opacity-25"></div>
    </div>

    <!-- Mobile sidebar -->
    <div x-show="sidebarOpen" 
         @click.outside="sidebarOpen = false"
         x-transition:enter="transition ease-in-out duration-300 transform"
         x-transition:enter-start="-translate-x-full"
         x-transition:enter-end="translate-x-0"
         x-transition:leave="transition ease-in-out duration-300 transform"
         x-transition:leave-start="translate-x-0"
         x-transition:leave-end="-translate-x-full"
         class="fixed inset-y-0 left-0 z-50 w-64 bg-white lg:hidden">
        <x-sidebar :user="$user" :role="$user->role" :active-tab="$activeTab ?? 'dashboard'" />
    </div>

    <!-- Desktop layout -->
    <div class="flex h-screen">
        <!-- Desktop sidebar -->
        <div class="hidden lg:flex lg:flex-shrink-0">
            <div class="flex flex-col w-64">
                <x-sidebar :user="$user" :role="$user->role" :active-tab="$activeTab ?? 'dashboard'" />
            </div>
        </div>

        <!-- Main content -->
        <div class="flex-1 flex flex-col min-w-0">
            <!-- Header -->
            <x-header :user="$user" :title="$title ?? 'Dashboard'" />

            <!-- Page content -->
            <main class="flex-1 relative z-0 focus:outline-none custom-scrollbar" style="overflow-y: auto;">
                <div class="py-6">
                    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                        <!-- Flash Messages -->
                        @if(session('success'))
                            <div class="mb-6 bg-green-50 border border-green-200 rounded-lg p-4">
                                <div class="flex">
                                    <i class="fas fa-check-circle text-green-400 mt-0.5"></i>
                                    <div class="ml-3">
                                        <p class="text-green-800">{{ session('success') }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if(session('error'))
                            <div class="mb-6 bg-red-50 border border-red-200 rounded-lg p-4">
                                <div class="flex">
                                    <i class="fas fa-exclamation-circle text-red-400 mt-0.5"></i>
                                    <div class="ml-3">
                                        <p class="text-red-800">{{ session('error') }}</p>
                                    </div>
                                </div>
                            </div>
                        @endif

                        @yield('dashboard-content')
                    </div>
                </div>
            </main>
        </div>
    </div>
</div>
@endsection