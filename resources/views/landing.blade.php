<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Karcis.in - Experience Redefined</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #FDFBF7;
        }

        .text-gradient {
            background: linear-gradient(to right, #000, #555);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .hero-img {
            border-radius: 40px;
            box-shadow: 0 50px 100px -20px rgba(0, 0, 0, 0.15);
        }

        .btn-black {
            background-color: #1A1A1A;
            color: white;
            transition: all 0.3s;
        }

        .btn-black:hover {
            background-color: #333;
            transform: translateY(-2px);
        }

        .btn-red {
            background-color: #BD2636;
            color: white;
            transition: all 0.3s;
        }

        .section-dark {
            background-color: #33312E;
            color: white;
        }
    </style>
</head>

<body class="antialiased">
    <!-- Nav -->
    <nav class="fixed top-0 w-full z-50 bg-[#FDFBF7]/80 backdrop-blur-md">
        <div class="max-w-7xl mx-auto px-10 h-24 flex justify-between items-center">
            <div class="flex items-center gap-12">
                <a href="/"
                    class="text-xs font-black uppercase tracking-[0.5em] text-slate-900 border-b-2 border-black pb-1">Karcis.in</a>
                <div
                    class="hidden md:flex items-center gap-8 text-[11px] font-black uppercase tracking-widest text-slate-400">
                    <a href="#" class="hover:text-black transition">Discover</a>
                    <a href="#" class="hover:text-black transition">Pricing</a>
                    <a href="#" class="hover:text-black transition">Journal</a>
                </div>
            </div>
            <div class="flex items-center gap-8">
                @auth
                    <a href="{{ route('owner.dashboard') }}"
                        class="text-[11px] font-black uppercase tracking-widest text-[#BD2636]">Dashboard</a>
                @else
                    <a href="{{ route('login') }}"
                        class="text-[11px] font-black uppercase tracking-widest text-slate-400">Login</a>
                @endauth
                <a href="{{ route('owner.events.create') }}"
                    class="px-8 py-3 btn-red text-[11px] font-black uppercase tracking-[0.2em] rounded-full">Create
                    Event</a>
            </div>
        </div>
    </nav>

    <!-- Hero -->
    <section class="pt-48 pb-24 px-10">
        <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 lg:items-center gap-24">
            <div>
                <h1 class="text-6xl md:text-8xl font-black text-slate-900 leading-[0.9] tracking-tighter">
                    Find your next <br> <span class="italic font-serif font-light text-[#BD2636]">experience</span>.
                </h1>
                <p class="mt-12 text-sm text-slate-500 max-w-sm leading-relaxed font-medium uppercase tracking-tight">
                    Curated architectural gatherings, avant-garde music, and culinary workshops designed for the modern
                    intellectual.
                </p>
                <div class="mt-16 flex items-center gap-6">
                    <button
                        class="px-10 py-5 btn-black text-[11px] font-black uppercase tracking-[0.3em] rounded-full">Explore
                        Now</button>
                    <button
                        class="text-[11px] font-black uppercase tracking-widest text-slate-400 hover:text-black transition flex items-center gap-3">
                        How it works
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8l4 4m0 0l-4 4m4-4H3" />
                        </svg>
                    </button>
                </div>
            </div>
            <div class="relative">
                <div class="hero-img aspect-[4/5] overflow-hidden bg-slate-100">
                    <img src="https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=2070&auto=format&fit=crop"
                        class="w-full h-full object-cover">
                </div>
                <!-- Decor -->
                <div class="absolute -top-12 -right-12 w-32 h-32 bg-[#F9EED4] rounded-full -z-10 opacity-60"></div>
                <div class="absolute -bottom-12 -left-12 w-48 h-48 bg-[#FAEBEB] rounded-full -z-10 opacity-60"></div>
            </div>
        </div>
    </section>

    <!-- Search Tool -->
    <section class="max-w-7xl mx-auto px-10 -mt-12 relative z-20">
        <div
            class="bg-white/70 backdrop-blur-2xl p-10 rounded-[40px] border border-white/50 shadow-2xl shadow-slate-200/50 grid grid-cols-1 md:grid-cols-4 gap-8 items-center">
            <div class="px-4">
                <p class="text-[10px] font-black uppercase tracking-widest text-[#BD2636] mb-1">WHERE</p>
                <p class="text-sm font-bold text-slate-800">Location</p>
            </div>
            <div class="px-4 md:border-l border-slate-100">
                <p class="text-[10px] font-black uppercase tracking-widest text-[#BD2636] mb-1">WHEN</p>
                <p class="text-sm font-bold text-slate-800">Date range</p>
            </div>
            <div class="px-4 md:border-l border-slate-100">
                <p class="text-[10px] font-black uppercase tracking-widest text-[#BD2636] mb-1">WHAT</p>
                <p class="text-sm font-bold text-slate-800">Architecture, Music...</p>
            </div>
            <div class="flex justify-end">
                <button
                    class="w-16 h-16 btn-red rounded-3xl flex items-center justify-center hover:scale-105 transition duration-500 shadow-xl shadow-red-100">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
            </div>
        </div>
    </section>

    <!-- Curated Picks -->
    <section class="py-48 px-10">
        <div class="max-w-7xl mx-auto">
            <div class="flex justify-between items-end mb-16">
                <div>
                    <h2 class="text-3xl font-black text-slate-900 tracking-tight">Curated Picks</h2>
                    <p class="text-[11px] font-bold text-slate-400 uppercase mt-2 tracking-widest">The most sought-after
                        experiences this season.</p>
                </div>
                <a href="#"
                    class="text-[11px] font-black uppercase tracking-widest text-[#BD2636] flex items-center gap-2">View
                    all &rarr;</a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-10">
                <!-- Large Card -->
                <div class="lg:col-span-2 group relative h-[500px] rounded-[40px] overflow-hidden bg-slate-900">
                    <img src="https://images.unsplash.com/photo-1514300344558-cc3761803708?q=80&w=2070&auto=format&fit=crop"
                        class="w-full h-full object-cover opacity-60 group-hover:scale-110 transition duration-[2s]">
                    <div
                        class="absolute inset-0 p-12 flex flex-col justify-end text-white bg-gradient-to-t from-black/80 to-transparent">
                        <span
                            class="inline-block px-3 py-1 bg-[#BD2636] text-[10px] font-black uppercase tracking-widest rounded-full mb-6 w-fit">BEST
                            SELLER</span>
                        <h3 class="text-4xl font-black tracking-tight leading-[0.9]">Brutalist Echoes: <br> Music in
                            Concrete</h3>
                        <p
                            class="mt-6 text-sm text-slate-300 max-w-sm font-medium leading-relaxed opacity-0 group-hover:opacity-100 transition duration-500">
                            An immersive audio-underground experience from the heart of central library.</p>
                        <div
                            class="mt-8 flex items-center gap-6 text-[10px] font-black uppercase tracking-[0.2em] text-slate-400">
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                OCT 12, 2026
                            </div>
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                STOCKHOLM
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Card -->
                <div class="group relative rounded-[40px] overflow-hidden bg-[#F7F2E9]">
                    <div class="h-1/2 overflow-hidden">
                        <img src="https://images.unsplash.com/photo-1497366216548-37526070297c?q=80&w=2069&auto=format&fit=crop"
                            class="w-full h-full object-cover group-hover:scale-110 transition duration-[2s]">
                    </div>
                    <div class="p-10">
                        <h3 class="text-2xl font-black tracking-tight text-slate-800">Design Lab Sessions</h3>
                        <p class="mt-4 text-xs text-slate-500 font-medium uppercase tracking-tight">Hands-on workshops
                            with industry leaders.</p>
                        <button
                            class="mt-10 px-8 py-4 border border-slate-200 text-[10px] font-black uppercase tracking-[0.2em] text-slate-800 rounded-full hover:bg-white transition">Book
                            Spot</button>
                    </div>
                </div>

                <!-- Bottom Row -->
                <div class="group relative rounded-[40px] overflow-hidden aspect-square lg:aspect-auto h-[350px]">
                    <img src="https://images.unsplash.com/photo-1541311094073-673b06990d16?q=80&w=2074&auto=format&fit=crop"
                        class="w-full h-full object-cover group-hover:scale-110 transition duration-[2s]">
                    <div
                        class="absolute inset-0 p-10 flex flex-col justify-end bg-gradient-to-t from-black/60 to-transparent">
                        <h3 class="text-xl font-bold text-white tracking-tight">The Midnight Parlor</h3>
                        <p class="text-[10px] text-slate-300 font-bold uppercase tracking-widest mt-2">Speak-easy jazz
                            and cocktails</p>
                    </div>
                </div>

                <div class="group relative rounded-[40px] overflow-hidden h-[350px]">
                    <img src="https://images.unsplash.com/photo-1490212002344-93339031c3bf?q=80&w=2070&auto=format&fit=crop"
                        class="w-full h-full object-cover group-hover:scale-110 transition duration-[2s]">
                    <div
                        class="absolute inset-0 p-10 flex flex-col justify-end bg-gradient-to-t from-black/60 to-transparent">
                        <h3 class="text-xl font-bold text-white tracking-tight">Mono Exhibition</h3>
                        <p class="text-[10px] text-slate-300 font-bold uppercase tracking-widest mt-2">Exploring silence
                            through art</p>
                    </div>
                </div>

                <div class="bg-[#FF7468] rounded-[40px] p-10 flex flex-col justify-between text-white group">
                    <div class="w-12 h-12 bg-white/20 rounded-2xl flex items-center justify-center">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-3xl font-black tracking-tight leading-none mb-4">Member <br> Early Access</h3>
                        <p class="text-[10px] font-bold text-white/70 uppercase mb-8">Get tickets 48h before general
                            release</p>
                        <a href="#"
                            class="text-[10px] font-black uppercase tracking-widest hover:pl-2 transition-all">Join
                            Collective &rarr;</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Visionary Section -->
    <section class="section-dark py-48 px-10 overflow-hidden relative">
        <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-24 relative z-10">
            <div>
                <p class="text-[10px] font-black uppercase tracking-[0.4em] text-[#BD2636] mb-4">FOR ORGANIZERS</p>
                <h2 class="text-6xl font-black leading-[0.9] tracking-tighter italic">The infrastructure <br> <span
                        class="not-italic text-white/20">for visionaries.</span></h2>
                <p class="mt-12 text-sm text-slate-400 max-w-sm leading-relaxed font-medium uppercase tracking-tight">
                    Scale your event with our premium ticketing, analytics, and community management tools. Built for
                    architects of experiences.
                </p>
                <div class="mt-16 flex items-center gap-6">
                    <button
                        class="px-10 py-5 btn-red text-[11px] font-black uppercase tracking-[0.3em] rounded-full">Start
                        Hosting</button>
                    <button
                        class="px-10 py-5 border border-white/20 text-[11px] font-black uppercase tracking-[0.3em] rounded-full hover:bg-white/5 transition">View
                        Features</button>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-6">
                <div class="bg-white/5 p-8 rounded-3xl border border-white/10">
                    <h4 class="text-4xl font-black text-white leading-none">99%</h4>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-4">Retention Rate</p>
                </div>
                <div class="bg-white/5 p-8 rounded-3xl border border-white/10">
                    <h4 class="text-4xl font-black text-white leading-none">50k+</h4>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-4">Global Hosts</p>
                </div>
                <div class="bg-white/5 p-8 rounded-3xl border border-white/10">
                    <h4 class="text-4xl font-black text-white leading-none">24h</h4>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-4">Payout Speed</p>
                </div>
                <div class="bg-white/5 p-8 rounded-3xl border border-white/10">
                    <h4 class="text-4xl font-black text-white leading-none">12M</h4>
                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mt-4">Tickets Sold</p>
                </div>
            </div>
        </div>
        <!-- Decorative SVG -->
        <div class="absolute -right-24 bottom-0 opacity-10 pointer-events-none">
            <svg width="600" height="600" viewBox="0 0 100 100">
                <circle cx="100" cy="100" r="80" fill="white" />
            </svg>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-slate-900 py-24 px-10 border-t border-white/10 text-slate-500">
        <div class="max-w-7xl mx-auto flex flex-col md:flex-row justify-between items-center gap-12">
            <div>
                <a href="/" class="text-sm font-black uppercase tracking-[0.5em] text-white">Karcis.in</a>
                <p class="mt-4 text-[10px] font-bold uppercase tracking-widest">&copy; 2026 Karcis.in - Experience
                    Redefined.</p>
            </div>
            <div class="flex gap-12 text-[10px] font-black uppercase tracking-[0.3em]">
                <a href="#" class="hover:text-white transition">Privacy</a>
                <a href="#" class="hover:text-white transition">Terms</a>
                <a href="#" class="hover:text-white transition">Contact</a>
                <a href="#" class="hover:text-white transition">Instagram</a>
            </div>
        </div>
    </footer>
</body>

</html>