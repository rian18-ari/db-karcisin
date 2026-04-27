@extends('layouts.owner')

@section('content')
    <div class="mb-8 flex justify-between items-end">
        <div>
            <h1 class="text-3xl font-bold text-slate-800">Participants List</h1>
            <p class="text-slate-500">Manage your event attendees and validate check-ins</p>
        </div>
    </div>

    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-100 border border-emerald-200 text-emerald-700 rounded-xl flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                    clip-rule="evenodd" />
            </svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left">
                <thead>
                    <tr class="bg-slate-50 border-b border-slate-100">
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Ticket Code</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">User</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Event & Package</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Check-in Status</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($bookings as $booking)
                        <tr class="hover:bg-slate-50 transition">
                            <td class="px-6 py-4">
                                <span
                                    class="font-mono text-sm font-semibold text-indigo-600 bg-indigo-50 px-2 py-1 rounded">#{{ $booking->ticket_code }}</span>
                            </td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-8 h-8 rounded-full bg-slate-200 flex items-center justify-center text-xs font-bold text-slate-600">
                                        {{ strtoupper(substr($booking->user->name, 0, 1)) }}
                                    </div>
                                    <div>
                                        <p class="text-sm font-semibold text-slate-800">{{ $booking->user->name }}</p>
                                        <p class="text-xs text-slate-500">{{ $booking->user->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4">
                                <p class="text-sm font-medium text-slate-800">
                                    {{ $booking->ticketPackage->event->title ?? 'N/A' }}</p>
                                <span class="text-xs text-slate-500">{{ $booking->ticketPackage->name }}</span>
                            </td>
                            <td class="px-6 py-4">
                                @if($booking->status == 'used' || $booking->check_in_at)
                                    <div class="flex flex-col">
                                        <span
                                            class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700 w-fit">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            Checked In
                                        </span>
                                        <span
                                            class="text-[10px] text-slate-400 mt-1">{{ \Carbon\Carbon::parse($booking->check_in_at)->format('d M, H:i') }}</span>
                                    </div>
                                @else
                                    <span
                                        class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-medium bg-amber-100 text-amber-700">
                                        <span class="w-1.5 h-1.5 rounded-full bg-amber-500 animate-pulse"></span>
                                        Waiting
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4">
                                @if($booking->status != 'used' && !$booking->check_in_at)
                                    <form action="{{ route('owner.bookings.checkin', $booking->id) }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-bold rounded-xl transition shadow-md shadow-indigo-100 hover:shadow-indigo-200">
                                            Check-in Now
                                        </button>
                                    </form>
                                @else
                                    <button disabled
                                        class="px-4 py-2 bg-slate-100 text-slate-400 text-xs font-bold rounded-xl cursor-not-allowed">
                                        Verified
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-12 text-center">
                                <div class="flex flex-col items-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 text-slate-300 mb-4" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    <p class="text-slate-500 font-medium">No participants found yet.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection