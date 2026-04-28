<?php

use Livewire\Volt\Component;
use App\Models\event;
use App\Models\bookings;
use Carbon\Carbon;

new class extends Component {
    public $event;
    public $ticketPackages;
    public $totalParticipants;

    public function mount($id)
    {
        $this->event = event::with('tickets.bookings')->find($id);

        abort_unless($this->event, 404);

        $this->ticketPackages = $this->event->tickets;
        $this->totalParticipants = $this->ticketPackages->sum(fn($tp) => $tp->bookings->count());
    }

    public function formatDate($date)
    {
        return $date ? Carbon::parse($date)->translatedFormat('d F Y') : '-';
    }

    public function formatTime($date)
    {
        return $date ? Carbon::parse($date)->format('H:i') : '-';
    }

    public function getStatusColor()
    {
        return match ($this->event->status) {
            'published' => ['bg' => 'bg-emerald-50', 'text' => 'text-emerald-600', 'dot' => 'bg-emerald-500', 'label' => 'LIVE'],
            'draft' => ['bg' => 'bg-amber-50', 'text' => 'text-amber-600', 'dot' => 'bg-amber-400', 'label' => 'DRAFT'],
            'closed' => ['bg' => 'bg-slate-100', 'text' => 'text-slate-500', 'dot' => 'bg-slate-400', 'label' => 'CLOSED'],
            'cancelled' => ['bg' => 'bg-red-50', 'text' => 'text-red-500', 'dot' => 'bg-red-400', 'label' => 'CANCELLED'],
            default => ['bg' => 'bg-slate-50', 'text' => 'text-slate-400', 'dot' => 'bg-slate-300', 'label' => strtoupper($this->event->status)],
        };
    }
};
?>

<div class="space-y-12" x-data="countdownTimer('{{ $event->start_date }}')" x-init="startCountdown()">

    {{-- Back Button & Header --}}
    <div>
        <a href="{{ route('owner.dashboard') }}"
            class="inline-flex items-center gap-2 text-[10px] font-black uppercase tracking-widest text-slate-400 hover:text-[#BD2636] transition mb-6">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
            </svg>
            Back to Dashboard
        </a>

        <div class="flex flex-col md:flex-row justify-between md:items-end gap-6">
            <div>
                <div class="flex items-center gap-3 mb-3">
                    @php $statusStyle = $this->getStatusColor(); @endphp
                    <span
                        class="inline-flex items-center gap-1.5 px-3 py-1 {{ $statusStyle['bg'] }} {{ $statusStyle['text'] }} text-[9px] font-black uppercase tracking-widest rounded-full">
                        <span class="w-1.5 h-1.5 rounded-full {{ $statusStyle['dot'] }}"></span>
                        {{ $statusStyle['label'] }}
                    </span>
                </div>
                <h1 class="text-4xl font-black text-slate-800 tracking-tighter uppercase leading-none">
                    {{ $event->title }}</h1>
                <p class="text-xs text-slate-400 font-bold mt-2 uppercase tracking-widest">
                    {{ $this->formatDate($event->start_date) }} • {{ $event->location }}
                </p>
            </div>
            <div class="flex items-center gap-4">
                <a href="{{ route('owner.dashboard') }}"
                    class="px-6 py-3 border-2 border-slate-100 text-[10px] font-black uppercase tracking-widest text-slate-400 rounded-xl hover:text-[#BD2636] hover:border-[#BD2636]/20 transition flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                    </svg>
                    Edit Event
                </a>
            </div>
        </div>
    </div>

    {{-- Countdown Section --}}
    <section>
        <h2 class="text-xs font-black uppercase tracking-[0.3em] text-slate-400 mb-8">Countdown to Event</h2>
        <div class="bg-gradient-to-br from-[#3A3835] to-[#2A2826] p-10 rounded-[32px] relative overflow-hidden">
            <div
                class="absolute top-0 right-0 w-64 h-64 bg-[#BD2636]/10 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2">
            </div>
            <div
                class="absolute bottom-0 left-0 w-48 h-48 bg-[#BD2636]/5 rounded-full blur-2xl translate-y-1/2 -translate-x-1/2">
            </div>

            <template x-if="isExpired">
                <div class="text-center py-4 relative z-10">
                    <p class="text-[10px] font-black uppercase tracking-[0.4em] text-white/40 mb-3">Event Status</p>
                    <h3 class="text-4xl font-black text-white uppercase tracking-tight">Event Telah Berlangsung</h3>
                </div>
            </template>

            <template x-if="!isExpired">
                <div class="grid grid-cols-4 gap-6 text-center relative z-10">
                    <div>
                        <p class="text-5xl md:text-6xl font-black text-white" x-text="days">00</p>
                        <p class="text-[10px] font-black uppercase tracking-[0.3em] text-white/40 mt-2">Hari</p>
                    </div>
                    <div>
                        <p class="text-5xl md:text-6xl font-black text-white" x-text="hours">00</p>
                        <p class="text-[10px] font-black uppercase tracking-[0.3em] text-white/40 mt-2">Jam</p>
                    </div>
                    <div>
                        <p class="text-5xl md:text-6xl font-black text-[#BD2636]" x-text="minutes">00</p>
                        <p class="text-[10px] font-black uppercase tracking-[0.3em] text-white/40 mt-2">Menit</p>
                    </div>
                    <div>
                        <p class="text-5xl md:text-6xl font-black text-white/60" x-text="seconds">00</p>
                        <p class="text-[10px] font-black uppercase tracking-[0.3em] text-white/40 mt-2">Detik</p>
                    </div>
                </div>
            </template>
        </div>
    </section>

    {{-- Overview Stats --}}
    <section>
        <h2 class="text-xs font-black uppercase tracking-[0.3em] text-slate-400 mb-8">Overview</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            {{-- Total Peserta --}}
            <div class="bg-[#E7F7EF] p-8 rounded-[32px] border border-slate-100/50 relative overflow-hidden group">
                <p class="text-[10px] font-black uppercase tracking-widest text-[#4A7F66] mb-2">Total Peserta</p>
                <h3 class="text-5xl font-black text-[#2D5A46]">{{ number_format($totalParticipants) }}</h3>
                <div class="mt-4 flex items-center gap-2 text-[10px] font-bold text-[#4A7F66]/60">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                            d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <span>SEMUA JENIS TIKET</span>
                </div>
                <div
                    class="absolute -right-4 -bottom-4 w-24 h-24 bg-[#D1EBE0] rounded-full opacity-50 group-hover:scale-110 transition duration-700">
                </div>
            </div>

            {{-- Jenis Tiket --}}
            <div class="bg-[#F9EED4] p-8 rounded-[32px] border border-slate-100/50 relative overflow-hidden group">
                <p class="text-[10px] font-black uppercase tracking-widest text-[#7D6C4A] mb-2">Jenis Tiket</p>
                <h3 class="text-5xl font-black text-[#5A4D33]">{{ $ticketPackages->count() }}</h3>
                <div class="mt-4 flex items-center gap-2 text-[10px] font-bold text-[#7D6C4A]/60">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                            d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                    </svg>
                    <span>PAKET TERSEDIA</span>
                </div>
                <div
                    class="absolute -right-4 -bottom-4 w-24 h-24 bg-[#EFE1C5] rounded-full opacity-50 group-hover:scale-110 transition duration-700">
                </div>
            </div>

            {{-- Status Event --}}
            <div class="bg-[#F7F2E9] p-8 rounded-[32px] border border-slate-100/50 relative overflow-hidden group">
                <p class="text-[10px] font-black uppercase tracking-widest text-[#8B7E66] mb-2">Status Event</p>
                <h3 class="text-3xl font-black text-[#5C5346] uppercase">{{ $event->status }}</h3>
                <div class="mt-4 flex items-center gap-2 text-[10px] font-bold text-[#8B7E66]/60">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-3 w-3" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                            d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" />
                    </svg>
                    <span>{{ $this->formatDate($event->start_date) }} — {{ $this->formatDate($event->end_date) }}</span>
                </div>
                <div
                    class="absolute -right-4 -bottom-4 w-24 h-24 bg-[#EBE4D6] rounded-full opacity-50 group-hover:scale-110 transition duration-700">
                </div>
            </div>
        </div>
    </section>

    {{-- Poster & Info --}}
    <div class="grid grid-cols-1 lg:grid-cols-5 gap-12">
        {{-- Poster --}}
        <section class="lg:col-span-2">
            <h2 class="text-xs font-black uppercase tracking-[0.3em] text-slate-400 mb-8">Poster Acara</h2>
            <div class="card overflow-hidden group">
                @if($event->image)
                    <div class="aspect-[3/4] overflow-hidden rounded-[24px]">
                        <img src="{{ asset($event->image) }}" alt="{{ $event->title }}"
                            class="w-full h-full object-cover group-hover:scale-105 transition duration-700">
                    </div>
                @else
                    <div
                        class="aspect-[3/4] bg-gradient-to-br from-[#F8F6F1] to-[#EBE4D6] flex flex-col items-center justify-center rounded-[24px]">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-slate-300 mb-4" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <p class="text-[10px] font-black uppercase tracking-[0.3em] text-slate-300">Belum ada poster</p>
                    </div>
                @endif
            </div>
        </section>

        {{-- Detail Info --}}
        <section class="lg:col-span-3 space-y-10">
            {{-- Informasi Acara --}}
            <div>
                <h2 class="text-xs font-black uppercase tracking-[0.3em] text-slate-400 mb-8">Informasi Acara</h2>
                <div class="card p-8 space-y-6">
                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 bg-[#FAEBEB] rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#BD2636]" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1">Tanggal
                                Pelaksanaan</p>
                            <p class="text-sm font-bold text-slate-800">{{ $this->formatDate($event->start_date) }} —
                                {{ $this->formatDate($event->end_date) }}</p>
                            <p class="text-xs text-slate-400 mt-1">{{ $this->formatTime($event->start_date) }} —
                                {{ $this->formatTime($event->end_date) }} WIB</p>
                        </div>
                    </div>

                    <div class="border-t border-slate-50"></div>

                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 bg-[#E7F7EF] rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#2D5A46]" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1">Lokasi Acara
                            </p>
                            <p class="text-sm font-bold text-slate-800">{{ $event->location }}</p>
                            <p class="text-xs text-slate-400 mt-1">Lat: {{ $event->latitude }}, Long:
                                {{ $event->longitude }}</p>
                        </div>
                    </div>

                    <div class="border-t border-slate-50"></div>

                    <div class="flex items-start gap-4">
                        <div class="w-10 h-10 bg-[#F9EED4] rounded-xl flex items-center justify-center flex-shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#7D6C4A]" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-1">Deskripsi
                            </p>
                            <p class="text-sm text-slate-600 leading-relaxed">{{ $event->description }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Peta Lokasi --}}
            <div>
                <h2 class="text-xs font-black uppercase tracking-[0.3em] text-slate-400 mb-8">Peta Lokasi</h2>
                <div class="card overflow-hidden" style="border-radius: 24px;">
                    <div id="event-map" style="height: 280px; width: 100%; z-index: 1;"></div>
                </div>
            </div>
        </section>
    </div>

    {{-- Ticket Packages --}}
    <section>
        <h2 class="text-xs font-black uppercase tracking-[0.3em] text-slate-400 mb-8">Paket Tiket</h2>
        <div class="card overflow-hidden">
            <table class="w-full text-left">
                <thead>
                    <tr
                        class="text-[10px] font-black uppercase tracking-widest text-slate-300 border-b border-slate-50">
                        <th class="px-10 py-6">Nama Tiket</th>
                        <th class="px-6 py-6">Harga</th>
                        <th class="px-6 py-6">Kuota</th>
                        <th class="px-6 py-6">Peserta</th>
                        <th class="px-10 py-6 text-right">Kapasitas</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50">
                    @forelse($ticketPackages as $ticket)
                        @php
                            $booked = $ticket->bookings->count();
                            $quota = $ticket->quota ?? 0;
                            $percentage = $quota > 0 ? round(($booked / $quota) * 100) : 0;
                        @endphp
                        <tr class="group hover:bg-slate-50/50 transition">
                            <td class="px-10 py-6">
                                <div class="flex items-center gap-4">
                                    <div class="w-10 h-10 rounded-xl bg-[#F9EED4] flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#7D6C4A]" fill="none"
                                            viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-800">{{ $ticket->name }}</p>
                                        <p class="text-[10px] text-slate-400 font-bold mt-0.5">{{ $ticket->desc }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-6">
                                <span class="text-sm font-black text-[#5A4D33]">Rp
                                    {{ number_format($ticket->price, 0, ',', '.') }}</span>
                            </td>
                            <td class="px-6 py-6">
                                <span
                                    class="text-sm font-bold text-slate-600">{{ $quota > 0 ? number_format($quota) : '∞' }}</span>
                            </td>
                            <td class="px-6 py-6">
                                <span
                                    class="px-2.5 py-1 bg-[#E7F7EF] text-[#2D5A46] text-[10px] font-black uppercase tracking-widest rounded-md border border-[#D1EBE0]">
                                    {{ number_format($booked) }} Orang
                                </span>
                            </td>
                            <td class="px-10 py-6">
                                <div class="flex items-center justify-end gap-3">
                                    <div class="w-28">
                                        <div
                                            class="flex justify-between text-[10px] font-bold text-slate-500 mb-1.5 uppercase tracking-tighter">
                                            <span>{{ $booked }}/{{ $quota > 0 ? $quota : '∞' }}</span>
                                        </div>
                                        <div class="h-1 w-full bg-slate-100 rounded-full overflow-hidden">
                                            <div class="h-full bg-[#BD2636] rounded-full transition-all duration-1000"
                                                style="width: {{ min($percentage, 100) }}%"></div>
                                        </div>
                                    </div>
                                    <span class="text-[10px] font-black text-slate-400">{{ $percentage }}%</span>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5"
                                class="py-20 text-center text-[10px] font-black uppercase tracking-[0.2em] text-slate-300">
                                Belum ada paket tiket untuk event ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </section>

    {{-- Event Timeline --}}
    <section>
        <h2 class="text-xs font-black uppercase tracking-[0.3em] text-slate-400 mb-8">Timeline Event</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
            <div class="card p-8">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-3 h-3 rounded-full bg-[#BD2636]"></div>
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Mulai Acara</p>
                </div>
                <h3 class="text-2xl font-black text-slate-800 tracking-tight">
                    {{ $this->formatDate($event->start_date) }}</h3>
                <p class="text-sm text-slate-400 font-bold mt-1">{{ $this->formatTime($event->start_date) }} WIB</p>
            </div>
            <div class="card p-8">
                <div class="flex items-center gap-4 mb-4">
                    <div class="w-3 h-3 rounded-full bg-slate-300"></div>
                    <p class="text-[10px] font-black uppercase tracking-widest text-slate-400">Selesai Acara</p>
                </div>
                <h3 class="text-2xl font-black text-slate-800 tracking-tight">{{ $this->formatDate($event->end_date) }}
                </h3>
                <p class="text-sm text-slate-400 font-bold mt-1">{{ $this->formatTime($event->end_date) }} WIB</p>
            </div>
        </div>
    </section>
</div>

@push('scripts')
    <script>
        function countdownTimer(targetDate) {
            return {
                days: '00',
                hours: '00',
                minutes: '00',
                seconds: '00',
                isExpired: false,
                interval: null,

                startCountdown() {
                    const target = new Date(targetDate).getTime();

                    this.updateCountdown(target);

                    this.interval = setInterval(() => {
                        this.updateCountdown(target);
                    }, 1000);
                },

                updateCountdown(target) {
                    const now = new Date().getTime();
                    const distance = target - now;

                    if (distance < 0) {
                        this.isExpired = true;
                        if (this.interval) clearInterval(this.interval);
                        return;
                    }

                    this.days = String(Math.floor(distance / (1000 * 60 * 60 * 24))).padStart(2, '0');
                    this.hours = String(Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60))).padStart(2, '0');
                    this.minutes = String(Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60))).padStart(2, '0');
                    this.seconds = String(Math.floor((distance % (1000 * 60)) / 1000)).padStart(2, '0');
                },

                destroy() {
                    if (this.interval) clearInterval(this.interval);
                }
            };
        }

        document.addEventListener('livewire:navigated', initMap);
        document.addEventListener('DOMContentLoaded', initMap);

        function initMap() {
            const mapEl = document.getElementById('event-map');
            if (!mapEl || mapEl._leaflet_id) return;

            const lat = {{ $event->latitude ?? -6.2 }};
            const lng = {{ $event->longitude ?? 106.8 }};

            const map = L.map('event-map', {
                scrollWheelZoom: false,
                zoomControl: true
            }).setView([lat, lng], 15);

            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '© OpenStreetMap'
            }).addTo(map);

            L.marker([lat, lng]).addTo(map)
                .bindPopup('<b>{{ $event->location }}</b>')
                .openPopup();

            setTimeout(() => map.invalidateSize(), 300);
        }
    </script>
@endpush