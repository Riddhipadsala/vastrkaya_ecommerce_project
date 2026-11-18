<!DOCTYPE html>
<html lang="en" data-theme="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard - Vastrkaya Luxury E-Commerce')</title>

    <!-- Pre-load theme script to prevent flicker -->
    <script>
        (function() {
            try {
                var savedTheme = localStorage.getItem('vk_admin_theme') || 
                    (window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light');
                document.documentElement.setAttribute('data-theme', savedTheme);
            } catch (e) {}
        })();
    </script>

    @include('partials.header-links')
    
    @vite(['resources/css/app.css', 'resources/css/admin-dashboard.css', 'resources/js/admin-dashboard.js', 'resources/js/app.js'])
    
    @yield('styles')
</head>

<body class="vk-admin-body">
    
    <div class="vk-admin-wrapper">

        @include('partials.sidebar')
        @include('partials.admin-main-content')

    </div>

    @include('partials.delete-modal')

    @yield('scripts')

</body>

</html>
