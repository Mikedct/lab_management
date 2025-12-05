<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel - Game Store')</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs" defer></script>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen text-gray-800">

    {{-- Navbar Admin --}}
    @include('layouts.partials.admin-navbar')

    {{-- Content --}}
    <main class="container mx-auto px-4 py-8">
        @yield('content')
    </main>

    {{-- Optional: Footer --}}
    @includeIf('layouts.partials.footer')

</body>
</html>
