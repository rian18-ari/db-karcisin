<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Karcis.in</title>
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
        <div class="hidden lg:block relative overflow-hidden h-[850px]">
            <img src="https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?q=80&w=2070&auto=format&fit=crop"
                class="w-full h-full object-cover scale-110">
            <div class="absolute inset-0 image-overlay p-16 flex flex-col justify-end text-white">
                <h1
                    class="text-4xl font-black tracking-tighter leading-none mb-4 italic font-serif font-light text-red-500">
                    BECOME <br> <span class="not-italic text-white">A VISIONARY.</span></h1>
                <p class="text-sm font-medium uppercase tracking-[0.2em] text-white/70">Scale your events with
                    professional tools.</p>
            </div>
            <!-- Logo overlay -->
            <div
                class="absolute top-12 left-12 px-6 py-2 bg-white/10 backdrop-blur-md border border-white/20 rounded-full">
                <span class="text-[10px] font-black uppercase tracking-[0.5em] text-white">KARCIS.IN</span>
            </div>
        </div>

        <!-- Right Side: Register Form -->
        <div class="p-12 lg:p-20 flex flex-col justify-center">
            <div class="mb-12">
                <h2 class="text-xs font-black uppercase tracking-[0.5em] text-slate-400 mb-4">Start Hosting</h2>
                <h3 class="text-4xl font-black text-slate-800 tracking-tight leading-none italic font-serif font-light">
                    <span class="not-italic font-black">Create</span> <br> <span class="text-crimson">account</span>.
                </h3>
            </div>

            <form action="{{ route('register') }}" method="POST" class="space-y-8">
                @csrf
                <div class="space-y-4">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">Full Name</label>
                    <input type="text" name="name" required
                        class="w-full text-sm font-bold text-slate-800 placeholder:text-slate-200 input-minimal bg-transparent pb-3"
                        placeholder="Organization or Individual Name">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="space-y-4">
                        <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">Email
                            Address</label>
                        <input type="email" name="email" required
                            class="w-full text-sm font-bold text-slate-800 placeholder:text-slate-200 input-minimal bg-transparent pb-3"
                            placeholder="name@email.com">
                    </div>
                    <div class="space-y-4">
                        <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">Phone</label>
                        <input type="text" name="phone" required
                            class="w-full text-sm font-bold text-slate-800 placeholder:text-slate-200 input-minimal bg-transparent pb-3"
                            placeholder="0812...">
                    </div>
                </div>

                <div class="space-y-4">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">Passcode</label>
                    <input type="password" name="password" required
                        class="w-full text-sm font-bold text-slate-800 placeholder:text-slate-200 input-minimal bg-transparent pb-3"
                        placeholder="••••••••">
                </div>

                <div class="space-y-4">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">Confirm
                        Passcode</label>
                    <input type="password" name="password_confirmation" required
                        class="w-full text-sm font-bold text-slate-800 placeholder:text-slate-200 input-minimal bg-transparent pb-3"
                        placeholder="••••••••">
                </div>

                <div class="pt-8 space-y-8">
                    <button type="submit"
                        class="w-full py-6 bg-crimson text-white text-[12px] font-black uppercase tracking-[0.4em] rounded-full shadow-2xl shadow-red-200/50 hover:bg-[#a01f2d] transition duration-300">
                        START HOSTING
                    </button>

                    <div class="text-center">
                        <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">
                            Already a host?
                            <a href="{{ route('login') }}"
                                class="text-crimson ml-2 border-b-2 border-red-100 hover:border-crimson transition pb-0.5">Access
                                dashboard</a>
                        </p>
                    </div>
                </div>
            </form>
        </div>
    </div>
</body>

</html>