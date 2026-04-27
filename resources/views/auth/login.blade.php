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
        }
    </style>
</head>

<body class="bg-indigo-600 flex items-center justify-center min-h-screen p-6">
    <div class="bg-white rounded-[32px] shadow-2xl overflow-hidden flex flex-col md:flex-row max-w-4xl w-full">
        <div class="hidden md:block w-1/2 bg-slate-900 p-12 text-white flex flex-col justify-between">
            <div>
                <h1
                    class="text-3xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-violet-400">
                    Karcis.in</h1>
                <p class="mt-8 text-lg font-medium">Join the elite community of event organizers.</p>
                <div class="mt-12 space-y-6">
                    <div class="flex items-center gap-4">
                        <div
                            class="w-10 h-10 rounded-xl bg-indigo-500/20 flex items-center justify-center text-indigo-400 font-bold">
                            1</div>
                        <p class="text-slate-400 text-sm">Professional Dashboard</p>
                    </div>
                    <div class="flex items-center gap-4">
                        <div
                            class="w-10 h-10 rounded-xl bg-indigo-500/20 flex items-center justify-center text-indigo-400 font-bold">
                            2</div>
                        <p class="text-slate-400 text-sm">Real-time Check-ins</p>
                    </div>
                    <div class="flex items-center gap-4">
                        <div
                            class="w-10 h-10 rounded-xl bg-indigo-500/20 flex items-center justify-center text-indigo-400 font-bold">
                            3</div>
                        <p class="text-slate-400 text-sm">Automated Ticketing</p>
                    </div>
                </div>
            </div>
            <p class="text-xs text-slate-500 italic">"Making your events unforgettable since 2026"</p>
        </div>

        <div class="w-full md:w-1/2 p-12">
            <h2 class="text-2xl font-bold text-slate-900">Welcome Back</h2>
            <p class="text-slate-500 mt-1 text-sm">Please enter your details to sign in</p>

            <form action="{{ route('login') }}" method="POST" class="mt-8 space-y-5">
                @csrf
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Email Address</label>
                    <input type="email" name="email" required value="{{ old('email') }}"
                        class="w-full px-5 py-4 rounded-2xl border border-slate-200 focus:ring-2 focus:ring-indigo-600 outline-none transition"
                        placeholder="name@company.com">
                    @error('email') <p class="text-xs text-red-500 mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <div class="flex justify-between items-center mb-2">
                        <label class="text-sm font-semibold text-slate-700">Password</label>
                        <a href="#" class="text-xs font-bold text-indigo-600">Forgot Password?</a>
                    </div>
                    <input type="password" name="password" required
                        class="w-full px-5 py-4 rounded-2xl border border-slate-200 focus:ring-2 focus:ring-indigo-600 outline-none transition"
                        placeholder="••••••••">
                </div>

                <button type="submit"
                    class="w-full py-4 bg-indigo-600 text-white font-bold rounded-2xl hover:bg-indigo-700 transition shadow-lg shadow-indigo-200">Sign
                    In</button>
            </form>

            <p class="mt-8 text-center text-sm text-slate-500">
                Don't have an account?
                <a href="{{ route('register') }}" class="text-indigo-600 font-bold">Create one today</a>
            </p>
        </div>
    </div>
</body>

</html>