<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Karcis.in</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #FDFBF7;
        }

        .text-crimson {
            color: #BD2636;
        }

        .bg-crimson {
            background-color: #BD2636;
        }

        .input-minimal {
            border-bottom: 2px solid #F0EFEA;
            transition: all 0.3s;
        }

        .input-minimal:focus {
            border-bottom-color: #BD2636;
            outline: none;
        }

        .image-overlay {
            background: linear-gradient(to bottom, rgba(0, 0, 0, 0.1), rgba(0, 0, 0, 0.6));
        }
    </style>
</head>

<body class="antialiased min-h-screen flex items-center justify-center p-6 bg-[#FDFBF7]">
    <div
        class="max-w-6xl w-full grid grid-cols-1 lg:grid-cols-2 bg-white rounded-[40px] overflow-hidden shadow-2xl shadow-slate-200/50">
        <!-- Left Side: Architectural Visual -->
        <div class="hidden lg:block relative overflow-hidden h-[700px]">
            <img src="https://images.unsplash.com/photo-1497366216548-37526070297c?q=80&w=2069&auto=format&fit=crop"
                class="w-full h-full object-cover">
            <div class="absolute inset-0 image-overlay p-16 flex flex-col justify-end text-white">
                <h1 class="text-4xl font-black tracking-tighter leading-none mb-4">ELEVATE YOUR <br> EVENT EXPERIENCE.
                </h1>
                <p class="text-sm font-medium uppercase tracking-[0.2em] text-white/70">Join the vanguard of event
                    organizers.</p>
            </div>
            <!-- Logo overlay -->
            <div
                class="absolute top-12 left-12 px-6 py-2 bg-white/10 backdrop-blur-md border border-white/20 rounded-full">
                <span class="text-[10px] font-black uppercase tracking-[0.5em] text-white">KARCIS.IN</span>
            </div>
        </div>

        <!-- Right Side: Login Form -->
        <div class="p-12 lg:p-24 flex flex-col justify-center">
            <div class="mb-12">
                <h2 class="text-xs font-black uppercase tracking-[0.5em] text-slate-400 mb-4">Welcome Back</h2>
                <h3 class="text-4xl font-black text-slate-800 tracking-tight leading-none italic font-serif font-light">
                    <span class="not-italic font-black text-slate-800">Sign in to</span> <br> <span
                        class="text-crimson">dashboard</span>.</h3>
            </div>

            @if(session('error'))
                <div
                    class="mb-8 p-4 bg-red-50 border border-red-100 rounded-2xl text-red-600 text-[10px] font-black uppercase tracking-widest">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('login') }}" method="POST" class="space-y-10">
                @csrf
                <div class="space-y-4">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">Email Address</label>
                    <input type="email" name="email" required autofocus
                        class="w-full text-lg font-bold text-slate-800 placeholder:text-slate-200 input-minimal bg-transparent pb-4"
                        placeholder="email@example.com">
                </div>

                <div class="space-y-4">
                    <div
                        class="flex justify-between items-center text-[10px] font-black uppercase tracking-widest text-slate-400">
                        <label>Password</label>
                        <a href="#" class="hover:text-crimson transition">Forgot?</a>
                    </div>
                    <input type="password" name="password" required
                        class="w-full text-lg font-bold text-slate-800 placeholder:text-slate-200 input-minimal bg-transparent pb-4"
                        placeholder="••••••••">
                </div>

                <div class="pt-4 space-y-8">
                    <button type="submit"
                        class="w-full py-6 bg-crimson text-white text-[12px] font-black uppercase tracking-[0.4em] rounded-full shadow-2xl shadow-red-200/50 hover:bg-[#a01f2d] transition duration-300">
                        ACCESS DASHBOARD
                    </button>

                    <div class="text-center">
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">
                            New here?
                            <a href="{{ route('register') }}"
                                class="text-crimson ml-2 border-b-2 border-red-100 hover:border-crimson transition pb-0.5">Create
                                Account</a>
                        </p>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>

</html>