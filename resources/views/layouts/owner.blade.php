<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owner Dashboard - Karcis.in</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
        integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin="" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .dark-glass {
            background: rgba(17, 24, 39, 0.8);
            backdrop-filter: blur(12px);
            border: 1px solid rgba(255, 255, 255, 0.1);
        }
    </style>
</head>

<body class="bg-slate-50 text-slate-900">
    <nav class="sticky top-0 z-50 glass border-b border-slate-200 py-4 px-6 md:px-12 flex justify-between items-center">
        <a href="/"
            class="text-2xl font-bold bg-gradient-to-r from-indigo-600 to-violet-600 bg-clip-text text-transparent">Karcis.in</a>
        <div class="space-x-6 flex items-center">
            <a href="{{ route('owner.dashboard') }}"
                class="text-sm font-medium hover:text-indigo-600 transition">Dashboard</a>
            <a href="{{ route('owner.events.create') }}"
                class="text-sm font-medium hover:text-indigo-600 transition hidden md:block">Create Event</a>
            <a href="{{ route('owner.bookings.index') }}"
                class="text-sm font-medium hover:text-indigo-600 transition hidden md:block">Participants</a>
            <div class="h-8 w-px bg-slate-200 mx-2"></div>
            <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit"
                    class="text-sm font-bold text-red-500 hover:text-red-700 transition">Logout</button>
            </form>
            <div
                class="h-10 w-10 rounded-2xl bg-indigo-600 flex items-center justify-center text-white font-bold text-sm shadow-lg shadow-indigo-100">
                {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
            </div>
        </div>
    </nav>

    <main class="max-w-7xl mx-auto py-10 px-6 md:px-12">
        @yield('content')
    </main>

    @stack('scripts')
</body>

</html>