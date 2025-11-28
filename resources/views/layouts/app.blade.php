<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'IzinOut - Sistem Perizinan Siswa Digital')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- External CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">

    <style>
        :root {
            --primary-blue: #3b82f6;
            --primary-blue-dark: #1d4ed8;
            --light-blue: #dbeafe;
            --gray-50: #f9fafb;
            --gray-100: #f3f4f6;
            --gray-200: #e5e7eb;
            --gray-300: #d1d5db;
            --gray-400: #9ca3af;
            --gray-500: #6b7280;
            --gray-600: #4b5563;
            --gray-700: #374151;
            --gray-800: #1f2937;
            --gray-900: #111827;
        }

        body {
            font-family: 'Figtree', sans-serif;
            font-size: 14px;
        }

        .btn-primary {
            @apply bg-blue-600 hover:bg-blue-700 text-white font-medium px-4 py-2 rounded-lg transition-colors;
        }

        .btn-secondary {
            @apply bg-gray-200 hover:bg-gray-300 text-gray-800 font-medium px-4 py-2 rounded-lg transition-colors;
        }

        .btn-success {
            @apply bg-green-600 hover:bg-green-700 text-white font-medium px-4 py-2 rounded-lg transition-colors;
        }

        .btn-danger {
            @apply bg-red-600 hover:bg-red-700 text-white font-medium px-4 py-2 rounded-lg transition-colors;
        }

        .card {
            @apply bg-white rounded-lg shadow-sm border border-gray-200;
        }

        .badge-success {
            @apply bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded;
        }

        .badge-warning {
            @apply bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded;
        }

        .badge-danger {
            @apply bg-red-100 text-red-800 text-xs font-medium px-2.5 py-0.5 rounded;
        }

        .badge-info {
            @apply bg-blue-100 text-blue-800 text-xs font-medium px-2.5 py-0.5 rounded;
        }

        .input-field {
            @apply w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent;
        }

        .sidebar-active {
            @apply bg-blue-50 text-blue-700 border-r-2 border-blue-600;
        }

        /* Mobile responsiveness */
        @media (max-width: 768px) {
            .mobile-hidden {
                display: none;
            }
        }

        /* Custom scrollbar */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f5f9;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 3px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }
    </style>

    @stack('styles')
</head>
<body class="bg-gray-50 antialiased">
    @yield('content')

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
    
    @stack('scripts')
</body>
</html>