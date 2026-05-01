<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Owner Dashboard - Karcis.in</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #FDFBF7;
        }

        .sidebar-bg {
            background-color: #F8F6F1;
        }

        .active-link {
            background-color: white;
            color: #BD2636 !important;
            border-radius: 12px;
            box-shadow: 0 4px 6px -1px rgb(0 0 0 / 0.05);
        }

        .btn-primary {
            background-color: #BD2636;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: #a01f2d;
            transform: translateY(-1px);
        }

        .card {
            background-color: white;
            border-radius: 24px;
            border: 1px solid #F0EFEA;
        }

        .footer-dark {
            background-color: #3A3835;
            color: #A8A6A1;
        }
    </style>
    @livewireStyles
</head>

<body class="antialiased text-slate-900">
    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside class="w-64 sidebar-bg border-r border-slate-200/50 flex flex-col fixed h-full z-50">
            <div class="p-8 flex flex-col h-full">
                <!-- Logo -->
                <div class="flex items-center gap-3 mb-12">
                    <div class="w-10 h-10 bg-[#BD2636] rounded-xl flex items-center justify-center text-white">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                        </svg>
                    </div>
                    <div>
                        <h1 class="text-sm font-extrabold tracking-tighter uppercase leading-none">Event Manager</h1>
                        <p class="text-[10px] text-slate-400 font-bold uppercase tracking-widest mt-1">Pro Account</p>
                    </div>
                </div>

                <!-- Nav -->
                <nav class="space-y-2 flex-grow">
                    <a href="{{ route('owner.dashboard') }}"
                        class="flex items-center gap-3 px-4 py-3 text-sm font-bold text-slate-500 hover:text-[#BD2636] transition {{ Request::is('owner/dashboard') ? 'active-link' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                        </svg>
                        Dashboard
                    </a>
                    <a href="{{ route('owner.events.create') }}"
                        class="flex items-center gap-3 px-4 py-3 text-sm font-bold text-slate-500 hover:text-[#BD2636] transition {{ Request::is('owner/events/create') ? 'active-link' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Events
                    </a>
                    <a href="{{ route('owner.bookings.index') }}"
                        class="flex items-center gap-3 px-4 py-3 text-sm font-bold text-slate-500 hover:text-[#BD2636] transition {{ Request::is('owner/participants') ? 'active-link' : '' }}">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                        </svg>
                        Participants
                    </a>
                </nav>

                <!-- Action & Footer -->
                <div class="mt-auto space-y-6">
                    <a href="{{ route('owner.events.create') }}"
                        class="flex items-center justify-center gap-2 w-full py-4 btn-primary text-white font-bold rounded-xl shadow-lg shadow-red-100">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        NEW EVENT
                    </a>

                    <div class="space-y-4">
                        <a href="#"
                            class="flex items-center gap-3 px-4 text-xs font-bold text-slate-400 hover:text-[#BD2636] transition uppercase tracking-widest">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                            Help
                        </a>
                        <form action="{{ route('logout') }}" method="POST">
                            @csrf
                            <button type="submit"
                                class="flex items-center gap-3 px-4 text-xs font-bold text-slate-400 hover:text-red-600 transition uppercase tracking-widest">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <main class="flex-grow ml-64 flex flex-col min-h-screen">
            <!-- Header -->
            <header class="h-20 px-10 flex justify-end items-center sticky top-0 z-40">
                <div class="flex items-center gap-6">
                    <button class="text-slate-400 hover:text-slate-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </button>
                    <div class="w-10 h-10 rounded-full border border-slate-200 overflow-hidden">
                        <img src="https://ui-avatars.com/api/?name={{ auth()->user()->name }}&background=E0F2FE&color=0EA5E9"
                            alt="User" class="w-full h-full object-cover">
                    </div>
                </div>
            </header>

            <!-- Content Area -->
            <div class="px-10 pb-10 flex-grow">
                {{ $slot ?? '' }}
                @yield('content')
            </div>

            <!-- Footer -->
            <footer class="footer-dark py-12 px-10">
                <div class="flex flex-col md:flex-row justify-between items-center max-w-7xl mx-auto gap-8">
                    <div>
                        <h2 class="text-xl font-bold text-white tracking-widest uppercase">Karcis.in</h2>
                        <p class="text-xs mt-2">&copy; 2026 Karcis.in Management. Designed for visionaries.</p>
                    </div>
                    <div class="flex gap-8 text-xs font-bold uppercase tracking-widest">
                        <a href="#" class="hover:text-white transition">Privacy</a>
                        <a href="#" class="hover:text-white transition">Terms</a>
                        <a href="#" class="hover:text-white transition">Contact</a>
                        <a href="#" class="hover:text-white transition">Instagram</a>
                    </div>
                </div>
            </footer>
        </main>
    </div>

    @livewireScripts
    @stack('scripts')
</body>

</html>