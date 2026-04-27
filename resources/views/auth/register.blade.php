<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join Karcis.in</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }
    </style>
</head>

<body class="bg-violet-600 flex items-center justify-center min-h-screen p-6">
    <div class="bg-white rounded-[32px] shadow-2xl overflow-hidden flex flex-col md:flex-row max-w-4xl w-full">
        <div class="hidden md:block w-1/3 bg-slate-900 p-12 text-white">
            <h1
                class="text-2xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-indigo-400 to-violet-400">
                Karcis.in</h1>
            <p class="mt-8 text-lg font-medium">Start your journey as an organizer today.</p>
            <p class="mt-4 text-sm text-slate-400 leading-relaxed">Experience the future of event management with tools
                built for speed and precision.</p>
        </div>

        <div class="w-full md:w-2/3 p-12">
            <h2 class="text-2xl font-bold text-slate-900">Create Account</h2>
            <p class="text-slate-500 mt-1 text-sm">Fill in the form to get started</p>

            <form action="{{ route('register') }}" method="POST" class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-5">
                @csrf
                <div class="md:col-span-2">
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Full Name</label>
                    <input type="text" name="name" required
                        class="w-full px-5 py-3 rounded-2xl border border-slate-200 focus:ring-2 focus:ring-violet-600 outline-none transition"
                        placeholder="John Doe">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Email</label>
                    <input type="email" name="email" required
                        class="w-full px-5 py-3 rounded-2xl border border-slate-200 focus:ring-2 focus:ring-violet-600 outline-none transition"
                        placeholder="john@example.com">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Phone</label>
                    <input type="text" name="phone" required
                        class="w-full px-5 py-3 rounded-2xl border border-slate-200 focus:ring-2 focus:ring-violet-600 outline-none transition"
                        placeholder="08123456789">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Password</label>
                    <input type="password" name="password" required
                        class="w-full px-5 py-3 rounded-2xl border border-slate-200 focus:ring-2 focus:ring-violet-600 outline-none transition"
                        placeholder="••••••••">
                </div>
                <div>
                    <label class="block text-sm font-semibold text-slate-700 mb-2">Confirm Password</label>
                    <input type="password" name="password_confirmation" required
                        class="w-full px-5 py-3 rounded-2xl border border-slate-200 focus:ring-2 focus:ring-violet-600 outline-none transition"
                        placeholder="••••••••">
                </div>

                <button type="submit"
                    class="md:col-span-2 mt-2 w-full py-4 bg-violet-600 text-white font-bold rounded-2xl hover:bg-violet-700 transition shadow-lg shadow-violet-200">Register
                    Now</button>
            </form>

            <p class="mt-8 text-center text-sm text-slate-500">
                Already part of the team?
                <a href="{{ route('login') }}" class="text-violet-600 font-bold">Sign in here</a>
            </p>
        </div>
    </div>
</body>

</html>