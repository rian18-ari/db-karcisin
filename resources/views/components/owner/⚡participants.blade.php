<?php

use Livewire\Volt\Component;
use App\Models\bookings;
use Illuminate\Support\Facades\Auth;

new class extends Component {
    public function with(): array
    {
        return [
            'bookings' => bookings::with(['user', 'ticketPackage.event'])
                ->latest()
                ->get(),
        ];
    }

    public function checkIn($id)
    {
        $booking = bookings::findOrFail($id);

        $booking->update([
            'check_in_at' => now(),
            'status' => 'used'
        ]);

        session()->flash('success', 'Participant checked in successfully!');
    }
};
?>

<div class="space-y-12">
    <!-- Header -->
    <div class="flex flex-col md:flex-row justify-between md:items-end gap-6 mb-12">
        <div>
            <p class="text-[10px] font-black uppercase tracking-[0.4em] text-slate-400 mb-2">Events • Active Sessions
            </p>
            <h1 class="text-4xl font-black text-slate-800 tracking-tighter uppercase leading-none">Midnight Jazz
                Sessions</h1>
        </div>
        <div class="flex items-center gap-4">
            <button
                class="px-6 py-3 border-2 border-slate-100 text-[10px] font-black uppercase tracking-widest text-slate-400 rounded-xl hover:text-[#BD2636] hover:border-[#BD2636]/20 transition flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                Contact All
            </button>
            <button
                class="px-6 py-3 btn-primary text-white text-[10px] font-black uppercase tracking-widest rounded-xl shadow-lg shadow-red-100 flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                </svg>
                Export List
            </button>
        </div>
    </div>

    <!-- Event Specific Stats -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
        <div class="bg-white p-8 rounded-[32px] border border-slate-100 relative overflow-hidden group">
            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">Total Participants</p>
            <h3 class="text-5xl font-black text-slate-800">{{ $bookings->count() }}</h3>
            <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-slate-50 rounded-full opacity-50"></div>
        </div>
        <div class="bg-white p-8 rounded-[32px] border border-slate-100 relative overflow-hidden group">
            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-2">VIP Access</p>
            <h3 class="text-5xl font-black text-slate-800">128</h3>
            <div class="absolute -right-4 -bottom-4 w-20 h-20 bg-[#F9EED4] rounded-full opacity-30"></div>
        </div>
        <div class="bg-[#E7F7EF] p-8 rounded-[32px] border border-slate-100/50 relative overflow-hidden group">
            <p class="text-[10px] font-black uppercase tracking-widest text-[#4A7F66] mb-2">Capacity Filled</p>
            <h3 class="text-5xl font-black text-[#2D5A46]">86%</h3>
        </div>
    </div>

    @if(session('success'))
        <div
            class="mb-6 p-4 bg-emerald-50 border border-emerald-100 text-emerald-700 text-xs font-black uppercase tracking-widest rounded-xl flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                    clip-rule="evenodd" />
            </svg>
            {{ session('success') }}
        </div>
    @endif

    <!-- Guest List -->
    <div class="card overflow-hidden">
        <div class="p-8 border-b border-slate-50 flex justify-between items-center bg-slate-50/30">
            <h4 class="text-sm font-black uppercase tracking-[0.2em] text-slate-800">Active Guest List</h4>
            <div class="flex items-center gap-4">
                <div
                    class="flex bg-white rounded-lg p-1 border border-slate-100 shadow-sm text-[8px] font-black uppercase tracking-widest">
                    <button class="px-3 py-1.5 bg-[#FDFBF7] text-[#BD2636] rounded-md shadow-sm">Filter: Status</button>
                    <button class="px-3 py-1.5 text-slate-400">Ticket: All</button>
                </div>
                <button class="text-slate-400 p-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                </button>
            </div>
        </div>

        <table class="w-full text-left">
            <thead>
                <tr class="text-[10px] font-black uppercase tracking-widest text-slate-300 border-b border-slate-50">
                    <th class="px-10 py-6">Participant Name</th>
                    <th class="px-6 py-6">Ticket Type</th>
                    <th class="px-6 py-6">Purchase Date</th>
                    <th class="px-6 py-6 text-center">Status</th>
                    <th class="px-10 py-6 text-right">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-50">
                @forelse($bookings as $booking)
                    <tr class="group hover:bg-slate-50/50 transition">
                        <td class="px-10 py-6">
                            <div class="flex items-center gap-4">
                                <div class="w-10 h-10 rounded-full border-2 border-slate-100 overflow-hidden">
                                    <img src="https://ui-avatars.com/api/?name={{ $booking->user->name }}&background=F8F6F1&color=BD2636&bold=true"
                                        class="w-full h-full object-cover">
                                </div>
                                <div>
                                    <p class="text-sm font-bold text-slate-800 leading-none mb-1">{{ $booking->user->name }}
                                    </p>
                                    <p class="text-[10px] font-bold text-slate-300 lowercase tracking-widest">
                                        {{ $booking->user->email }}</p>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-6">
                            <span
                                class="px-2.5 py-1 bg-[#F9EED4] text-[#7D6C4A] text-[8px] font-black uppercase tracking-widest rounded-md border border-[#EFE1C5]">
                                {{ $booking->ticketPackage->name }}
                            </span>
                        </td>
                        <td class="px-6 py-6">
                            <p class="text-[10px] font-black uppercase tracking-widest text-[#8B7E66]">
                                {{ $booking->created_at->format('M d, Y') }}
                            </p>
                        </td>
                        <td class="px-6 py-6">
                            <div class="flex items-center justify-center gap-2">
                                @if($booking->status == 'used' || $booking->check_in_at)
                                    <div class="w-1.5 h-1.5 rounded-full bg-emerald-500"></div>
                                    <span
                                        class="text-[10px] font-black uppercase tracking-widest text-emerald-600">CONFIRMED</span>
                                @else
                                    <div class="w-1.5 h-1.5 rounded-full bg-amber-400"></div>
                                    <span class="text-[10px] font-black uppercase tracking-widest text-amber-600">PENDING</span>
                                @endif
                            </div>
                        </td>
                        <td class="px-10 py-6 text-right">
                            @if($booking->status != 'used' && !$booking->check_in_at)
                                <button wire:click="checkIn({{ $booking->id }})"
                                    class="p-2 text-slate-300 hover:text-[#BD2636] transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                                        stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M5 13l4 4L19 7" />
                                    </svg>
                                </button>
                            @endif
                            <button class="p-2 text-slate-200">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                        d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                </svg>
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5"
                            class="py-20 text-center text-[10px] font-black uppercase tracking-[0.2em] text-slate-300">
                            No participants yet for current event.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <!-- Pagination Placeholder -->
        <div class="p-10 border-t border-slate-50 flex flex-col md:flex-row justify-between items-center gap-6">
            <p class="text-[9px] font-black uppercase tracking-widest text-slate-300">Showing 1 of 12 pages</p>
            <div class="flex items-center gap-2">
                <button
                    class="w-8 h-8 rounded-lg bg-[#BD2636] text-white flex items-center justify-center text-[10px] font-black shadow-lg shadow-red-100">1</button>
                <button
                    class="w-8 h-8 rounded-lg text-slate-400 hover:bg-slate-50 flex items-center justify-center text-[10px] font-black">2</button>
                <button
                    class="w-8 h-8 rounded-lg text-slate-400 hover:bg-slate-50 flex items-center justify-center text-[10px] font-black">3</button>
                <button
                    class="w-8 h-8 rounded-lg text-slate-400 hover:bg-slate-50 flex items-center justify-center text-[10px] font-black">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M9 5l7 7-7 7" />
                    </svg>
                </button>
            </div>
        </div>
    </div>
</div>