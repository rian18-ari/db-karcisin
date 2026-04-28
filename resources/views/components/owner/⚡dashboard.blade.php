<?php

use Livewire\Volt\Component;
use App\Models\event;
use Illuminate\Support\Facades\Auth;
use function Livewire\Volt\layout;


new class extends Component {
    public function with(): array
    {
        return [
            'events' => event::where('user_id', Auth::id())->latest()->get(),
        ];
    }
};
?>

<div class="space-y-12">
    <!-- Section: Overview -->
    <section>
        <h2 class="text-xs font-black uppercase tracking-[0.3em] text-slate-400 mb-8">Overview</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <!-- Total Events -->
            <div class="bg-[#F7F2E9] p-8 rounded-[32px] border border-slate-100/50 relative overflow-hidden group">
                <p class="text-[10px] font-black uppercase tracking-widest text-[#8B7E66] mb-2">Total Events</p>
                <div class="flex items-baseline gap-2">
                    <h3 class="text-5xl font-black text-[#5C5346]">{{ $events->count() }}</h3>
                </div>
                <div class="mt-4 flex items-center gap-2 text-[10px] font-bold text-[#8B7E66]/60">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                    <span>+12% THIS MONTH</span>
                </div>
                <!-- Decor -->
                <div
                    class="absolute -right-4 -bottom-4 w-24 h-24 bg-[#EBE4D6] rounded-full opacity-50 group-hover:scale-110 transition duration-700">
                </div>
            </div>

            <!-- Total Participants -->
            <div class="bg-[#E7F7EF] p-8 rounded-[32px] border border-slate-100/50 relative overflow-hidden group">
                <p class="text-[10px] font-black uppercase tracking-widest text-[#4A7F66] mb-2">Total Participants</p>
                <h3 class="text-5xl font-black text-[#2D5A46]">1,482</h3>
                <div class="mt-4 flex items-center gap-2 text-[10px] font-bold text-[#4A7F66]/60">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <span>ACTIVE ACROSS ALL POOLS</span>
                </div>
                <!-- Decor -->
                <div
                    class="absolute -right-4 -bottom-4 w-24 h-24 bg-[#D1EBE0] rounded-full opacity-50 group-hover:scale-110 transition duration-700">
                </div>
            </div>

            <!-- Total Revenue -->
            <div class="bg-[#F9EED4] p-8 rounded-[32px] border border-slate-100/50 relative overflow-hidden group">
                <p class="text-[10px] font-black uppercase tracking-widest text-[#7D6C4A] mb-2">Total Revenue</p>
                <h3 class="text-5xl font-black text-[#5A4D33]">$42.8k</h3>
                <div class="mt-4 flex items-center gap-2 text-[10px] font-bold text-[#7D6C4A]/60">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                            d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                    <span>PROCESSED VIA KARCISPAY</span>
                </div>
                <!-- Decor -->
                <div
                    class="absolute -right-4 -bottom-4 w-24 h-24 bg-[#EFE1C5] rounded-full opacity-50 group-hover:scale-110 transition duration-700">
                </div>
            </div>
        </div>
    </section>

    <!-- Section: Active Events -->
    <section>
        <div class="flex justify-between items-end mb-8">
            <h2 class="text-xs font-black uppercase tracking-[0.3em] text-slate-400">Your Active Events</h2>
            <a href="#"
                class="text-[10px] font-black uppercase tracking-widest text-[#BD2636] border-b-2 border-[#BD2636]/20 hover:border-[#BD2636] transition pb-1">View
                All Schedule</a>
        </div>

        <div class="card overflow-hidden">
            <table class="w-full text-left">
                <thead>
                    <tr
                        class="text-[10px] font-black uppercase tracking-widest text-slate-400 border-b border-slate-50">
                        <th class="px-10 py-6">Event Details</th>
                        <th class="px-6 py-6">Status</th>
                        <th class="px-6 py-6">Capacity</th>
                        <th class="px-10 py-6 text-right">Quick Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @foreach($events as $event)
                        <tr class="group hover:bg-slate-50/50 transition">
                            <td class="px-10 py-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 rounded-xl bg-slate-100 overflow-hidden">
                                        <img src="{{ asset($event->image) }}" class="w-full h-full object-cover">
                                    </div>
                                    <div>
                                        <h4 class="text-sm font-bold text-slate-800">{{ $event->title }}</h4>
                                        <p class="text-[10px] text-slate-400 font-bold mt-1 uppercase tracking-tight">
                                            {{ $event->start_date }} - {{ $event->end_date }} • {{ $event->location }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-6">
                                <span
                                    class="px-3 py-1 bg-emerald-50 text-emerald-600 text-[10px] font-black uppercase tracking-widest rounded-full">LIVE</span>
                            </td>
                            <td class="px-6 py-6">
                                <div class="w-32">
                                    <div
                                        class="flex justify-between text-[10px] font-bold text-slate-500 mb-1.5 uppercase tracking-tighter">
                                        <span>450/500</span>
                                    </div>
                                    <div class="h-1 w-full bg-slate-100 rounded-full overflow-hidden">
                                        <div class="h-full bg-slate-800 w-[90%] transition-all duration-1000"></div>
                                    </div>
                                </div>
                            </td>
                            <td class="px-10 py-6">
                                <div class="flex justify-end gap-3 opacity-0 group-hover:opacity-100 transition">
                                    <a href="{{ route('owner.event.detail', $event->id) }}" class="p-2 text-slate-400 hover:text-[#BD2636] transition">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </a>
                                    <button class="p-2 text-slate-400 hover:text-slate-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                                        </svg>
                                    </button>
                                    <button class="p-2 text-slate-400 hover:text-slate-600">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </section>

    <!-- Section: Activity & Update -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
        <!-- Recent Activity -->
        <section>
            <h2 class="text-xs font-black uppercase tracking-[0.3em] text-slate-400 mb-8">Recent Activity</h2>
            <div class="space-y-8 pl-4">
                <div class="flex gap-6 relative">
                    <div class="absolute left-[-17px] top-2 w-2.5 h-2.5 rounded-full bg-[#BD2636]"></div>
                    <div class="absolute left-[-13px] top-5 w-px h-full bg-slate-100"></div>
                    <div>
                        <h4 class="text-sm font-bold text-slate-800 uppercase tracking-tight">New Participant
                            Registration</h4>
                        <p class="text-xs text-slate-500 mt-1">James Wilson registered for Summer Music Festival</p>
                        <p class="text-[10px] font-bold text-slate-300 uppercase mt-2">2 minutes ago</p>
                    </div>
                </div>
                <div class="flex gap-6 relative">
                    <div class="absolute left-[-17px] top-2 w-2.5 h-2.5 rounded-full bg-amber-400"></div>
                    <div class="absolute left-[-13px] top-5 w-px h-full bg-slate-100"></div>
                    <div>
                        <h4 class="text-sm font-bold text-slate-800 uppercase tracking-tight text-[#8B7E66]/80">Payout
                            Successful</h4>
                        <p class="text-xs text-slate-500 mt-1">Monthly revenue of $12,400 has been transferred to your
                            bank</p>
                        <p class="text-[10px] font-bold text-slate-300 uppercase mt-2">1 hour ago</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Platform Update -->
        <section>
            <div class="bg-[#FAEBEB] p-10 rounded-[40px] border border-red-100/50">
                <h4 class="text-sm font-black uppercase tracking-[0.2em] text-[#BD2636] mb-4">Platform Update</h4>
                <p class="text-sm text-[#BD2636]/70 leading-relaxed font-medium">
                    We've launched the new KarcisPay integration. You can now process participant transactions directly
                    with 0% platform fee.
                </p>
                <div class="mt-10">
                    <a href="#"
                        class="inline-block px-8 py-4 btn-primary text-white text-[10px] font-black uppercase tracking-[0.2em] rounded-xl shadow-lg shadow-red-100">
                        LEARN MORE
                    </a>
                </div>
            </div>
        </section>
    </div>
</div>