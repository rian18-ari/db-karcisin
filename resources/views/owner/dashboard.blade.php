@extends('layouts.owner')

@section('content')
    <div class="mb-10">
        <h1 class="text-3xl font-extrabold text-slate-900 leading-tight">Welcome back, {{ auth()->user()->name }}! 👋</h1>
        <p class="text-slate-500 mt-1">Here's what's happening with your events today.</p>
    </div>

    <!-- Stats Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
        <div
            class="bg-white p-8 rounded-[32px] border border-slate-100 shadow-sm hover:shadow-xl hover:shadow-slate-100 transition-all">
            <div class="w-12 h-12 rounded-2xl bg-indigo-50 text-indigo-600 flex items-center justify-center mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
            </div>
            <p class="text-slate-500 text-sm font-medium">Total Events</p>
            <h3 class="text-3xl font-extrabold text-slate-900 mt-1">12</h3>
        </div>

        <div
            class="bg-white p-8 rounded-[32px] border border-slate-100 shadow-sm hover:shadow-xl hover:shadow-slate-100 transition-all">
            <div class="w-12 h-12 rounded-2xl bg-emerald-50 text-emerald-600 flex items-center justify-center mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                </svg>
            </div>
            <p class="text-slate-500 text-sm font-medium">Total Participants</p>
            <h3 class="text-3xl font-extrabold text-slate-900 mt-1">842</h3>
        </div>

        <div
            class="bg-white p-8 rounded-[32px] border border-slate-100 shadow-sm hover:shadow-xl hover:shadow-slate-100 transition-all">
            <div class="w-12 h-12 rounded-2xl bg-amber-50 text-amber-600 flex items-center justify-center mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <p class="text-slate-500 text-sm font-medium">Checked In</p>
            <h3 class="text-3xl font-extrabold text-slate-900 mt-1">320</h3>
        </div>

        <div
            class="bg-white p-8 rounded-[32px] border border-slate-100 shadow-sm hover:shadow-xl hover:shadow-slate-100 transition-all">
            <div class="w-12 h-12 rounded-2xl bg-violet-50 text-violet-600 flex items-center justify-center mb-6">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <p class="text-slate-500 text-sm font-medium">Estimated Revenue</p>
            <h3 class="text-3xl font-extrabold text-slate-900 mt-1">$4.2k</h3>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Quick Actions -->
        <div class="bg-slate-900 rounded-[40px] p-10 text-white relative overflow-hidden">
            <div class="relative z-10">
                <h4 class="text-2xl font-bold">Ready to host <br> more?</h4>
                <p class="text-slate-400 mt-4 max-w-xs">Creation process made easy with our automated systems.</p>
                <a href="{{ route('owner.events.create') }}"
                    class="inline-block mt-8 px-8 py-4 bg-white text-slate-900 font-bold rounded-2xl hover:scale-105 transition duration-300">Create
                    New Event</a>
            </div>
            <!-- Decorative SVG -->
            <svg class="absolute right-0 bottom-0 opacity-20 pointer-events-none" width="200" height="200"
                viewBox="0 0 100 100">
                <circle cx="100" cy="100" r="80" fill="white" />
            </svg>
        </div>

        <!-- Latest Bookings Info -->
        <div class="bg-white rounded-[40px] border border-slate-100 p-8 shadow-sm">
            <div class="flex justify-between items-center mb-8">
                <h4 class="text-xl font-bold text-slate-900">Recent Participants</h4>
                <a href="{{ route('owner.bookings.index') }}" class="text-sm font-bold text-indigo-600 hover:underline">View
                    All</a>
            </div>
            <div class="space-y-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div
                            class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center font-bold text-slate-600">
                            JD</div>
                        <div>
                            <p class="text-sm font-bold text-slate-900">Jane Doe</p>
                            <p class="text-xs text-slate-500">Music Festival 2026</p>
                        </div>
                    </div>
                    <span class="text-xs font-bold text-slate-400">2m ago</span>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div
                            class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center font-bold text-slate-600">
                            MS</div>
                        <div>
                            <p class="text-sm font-bold text-slate-900">Mark Smith</p>
                            <p class="text-xs text-slate-500">Tech Conference</p>
                        </div>
                    </div>
                    <span class="text-xs font-bold text-slate-400">1h ago</span>
                </div>
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-4">
                        <div
                            class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center font-bold text-slate-600">
                            RK</div>
                        <div>
                            <p class="text-sm font-bold text-slate-900">Rina Kim</p>
                            <p class="text-xs text-slate-500">Art Workshop</p>
                        </div>
                    </div>
                    <span class="text-xs font-bold text-slate-400">3h ago</span>
                </div>
            </div>
        </div>
    </div>
@endsection