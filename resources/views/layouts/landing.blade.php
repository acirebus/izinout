<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="IzinOut - Platform digital untuk manajemen perizinan siswa keluar sekolah dengan sistem verifikasi QR code">
    <title>@yield('title', 'IzinOut - Sistem Perizinan Siswa Digital')</title>
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Custom Styles -->
    <style>
        html {
            scroll-behavior: smooth;
        }
        
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
        
        .animate-fade-in-up {
            animation: fadeInUp 0.6s ease-out;
        }
    </style>
    
    @stack('styles')
</head>
<body class="bg-white antialiased">
    @yield('content')
    
    @stack('scripts')
</body>
</html>
