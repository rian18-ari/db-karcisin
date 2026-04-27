<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Karcis.in - Modern Event Ticketing Platform</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        .glass {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(10px);
        }

        .text-gradient {
            background: linear-gradient(to right, #4F46E5, #9333EA);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }
    </style>
</head>

<body class="bg-[#F8FAFC]">
    <!-- Navbar -->
    <nav class="fixed top-0 w-full z-50 glass border-b border-white/20">
        <div class="max-w-7xl mx-auto px-6 h-20 flex justify-between items-center">
            <a href="/" class="text-2xl font-extrabold text-gradient">Karcis.in</a>
            <div class="hidden md:flex items-center space-x-8">
                <a href="#about" class="text-sm font-semibold text-slate-600 hover:text-indigo-600 transition">About</a>
                <a href="#events"
                    class="text-sm font-semibold text-slate-600 hover:text-indigo-600 transition">Events</a>
                @auth
                    <a href="{{ route('owner.dashboard') }}"
                        class="px-6 py-2.5 bg-indigo-600 text-white text-sm font-bold rounded-full shadow-lg shadow-indigo-200 hover:scale-105 transition">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="text-sm font-semibold text-slate-600">Login</a>
                    <a href="{{ route('register') }}"
                        class="px-6 py-2.5 bg-indigo-600 text-white text-sm font-bold rounded-full shadow-lg shadow-indigo-200 hover:scale-105 transition">Get
                        Started</a>
                @endauth
            </div>
        </div>
    </nav>

    <!-- Hero -->
    <section class="pt-40 pb-20 px-6">
        <div class="max-w-7xl mx-auto text-center">
            <span
                class="px-4 py-2 bg-indigo-50 text-indigo-600 text-xs font-bold rounded-full uppercase tracking-wider">Revolutionizing
                Events</span>
            <h1 class="text-5xl md:text-7xl font-extrabold text-slate-900 mt-6 leading-tight">
                Discover & Create <br> <span class="text-gradient">Epic Experiences</span>
            </h1>
            <p class="mt-6 text-xl text-slate-500 max-w-2xl mx-auto leading-relaxed">
                The most seamless way to manage tickeing, tracking, and check-ins for your next big event.
            </p>
            <div class="mt-10 flex flex-col md:flex-row items-center justify-center gap-4">
                <a href="#events"
                    class="w-full md:w-auto px-10 py-5 bg-indigo-600 text-white font-bold rounded-2xl shadow-xl shadow-indigo-200 hover:-translate-y-1 transition">Find
                    Events</a>
                <a href="{{ route('register') }}"
                    class="w-full md:w-auto px-10 py-5 bg-white text-slate-900 font-bold rounded-2xl border border-slate-200 hover:bg-slate-50 transition">Host
                    an Event</a>
            </div>
        </div>
    </section>

    <!-- Featured Events -->
    <section id="events" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-6">
            <div class="flex justify-between items-end mb-12">
                <div>
                    <h2 class="text-3xl font-bold text-slate-900">Upcoming Events</h2>
                    <p class="text-slate-500 mt-2">Handpicked experiences for you</p>
                </div>
                <button class="text-indigo-600 font-bold flex items-center gap-2 hover:gap-3 transition-all">
                    View all <span>&rarr;</span>
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                @forelse($events as $event)
                    <div
                        class="group bg-white rounded-[32px] overflow-hidden border border-slate-100 hover:shadow-2xl hover:shadow-slate-200 transition-all duration-500">
                        <div class="relative h-64 overflow-hidden">
                            <img src="{{ asset($event->image) }}"
                                class="w-full h-full object-cover group-hover:scale-110 transition duration-700">
                            <div
                                class="absolute top-4 left-4 px-4 py-2 glass rounded-full text-xs font-bold text-indigo-600 uppercase">
                                {{ $event->category->name ?? 'Event' }}
                            </div>
                        </div>
                        <div class="p-8">
                            <div class="flex items-center gap-2 text-slate-400 text-sm mb-3 font-medium">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                {{ \Carbon\Carbon::parse($event->start_date)->format('M d, Y') }}
                            </div>
                            <h3 class="text-xl font-bold text-slate-900 group-hover:text-indigo-600 transition">
                                {{ $event->title }}</h3>
                            <p class="text-slate-500 mt-2 line-clamp-2 text-sm">{{ $event->description }}</p>

                            <div class="mt-6 pt-6 border-t border-slate-50 flex items-center justify-between">
                                <div class="flex items-center gap-2">
                                    <span class="text-sm font-bold text-slate-900">Start from</span>
                                    <span class="text-lg font-extrabold text-indigo-600">Free</span>
                                </div>
                                <button
                                    class="p-3 bg-indigo-50 text-indigo-600 rounded-xl hover:bg-indigo-600 hover:text-white transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 4v16m8-8H4" />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-span-full py-20 text-center text-slate-400 font-medium">
                        More events are coming soon!
                    </div>
                @endforelse
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-white border-t border-slate-100 py-12">
        <div class="max-w-7xl mx-auto px-6 text-center">
            <p class="text-2xl font-extrabold text-gradient">Karcis.in</p>
            <p class="mt-4 text-slate-400 text-sm italic">Making events unforgettable since 2026</p>
            <div class="mt-6 flex justify-center space-x-6 text-slate-400 text-sm">
                <a href="#">Privacy Policy</a>
                <a href="#">Terms of Service</a>
                <a href="#">Contact Us</a>
            </div>
            <p class="mt-8 text-xs text-slate-300">&copy; 2026 Karcis.in. All rights reserved.</p>
        </div>
    </footer>
</body>

</html>