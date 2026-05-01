<?php

use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use App\Models\event;
use App\Models\ticket_package;
use App\Models\categories;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

new class extends Component {
    use WithFileUploads;

    // Event fields
    public $title;
    public $description;
    public $start_date;
    public $end_date;
    public $location;
    public $latitude;
    public $longitude;
    public $category_id;
    public $image;

    // Ticket packages (array of rows)
    public array $tickets = [];

    public function mount()
    {
        $this->category_id = categories::first()?->id;
        // Default: satu baris tiket kosong
        $this->tickets = [
            ['name' => '', 'desc' => '', 'price' => '', 'quota' => ''],
        ];
    }

    public function with(): array
    {
        return [
            'categories' => categories::all(),
        ];
    }

    public function addTicket(): void
    {
        $this->tickets[] = ['name' => '', 'desc' => '', 'price' => '', 'quota' => ''];
    }

    public function removeTicket(int $index): void
    {
        unset($this->tickets[$index]);
        $this->tickets = array_values($this->tickets);
    }

    public function store()
    {
        $this->validate([
            'title'              => 'required|string|max:255',
            'description'        => 'required',
            'latitude'           => 'required|numeric',
            'longitude'          => 'required|numeric',
            'location'           => 'required|string',
            'start_date'         => 'required|date',
            'end_date'           => 'required|date|after:start_date',
            'category_id'        => 'required|exists:categories,id',
            'image'              => 'required|image|max:2048',
            'tickets'            => 'required|array|min:1',
            'tickets.*.name'     => 'required|string|max:255',
            'tickets.*.desc'     => 'required|string',
            'tickets.*.price'    => 'required|numeric|min:0',
            'tickets.*.quota'    => 'nullable|integer|min:1',
        ], [
            'tickets.*.name.required'  => 'Nama paket tiket wajib diisi.',
            'tickets.*.desc.required'  => 'Deskripsi benefit wajib diisi.',
            'tickets.*.price.required' => 'Harga tiket wajib diisi.',
            'tickets.*.price.numeric'  => 'Harga harus berupa angka.',
        ]);

        $imageName = time() . '_' . Str::slug($this->title) . '.' . $this->image->getClientOriginalExtension();
        $this->image->storeAs('events', $imageName, 'public');
        $imagePath = 'events/' . $imageName;

        $newEvent = event::create([
            'title'       => $this->title,
            'slug'        => Str::slug($this->title) . '-' . Str::random(5),
            'description' => $this->description,
            'latitude'    => $this->latitude,
            'longitude'   => $this->longitude,
            'location'    => $this->location,
            'start_date'  => $this->start_date,
            'end_date'    => $this->end_date,
            'category_id' => $this->category_id,
            'image'       => $imagePath,
            'user_id'     => Auth::id(),
            'status'      => 'published',
        ]);

        foreach ($this->tickets as $ticket) {
            ticket_package::create([
                'event_id' => $newEvent->id,
                'name'     => $ticket['name'],
                'desc'     => $ticket['desc'],
                'price'    => $ticket['price'],
                'quota'    => $ticket['quota'] ?: null,
            ]);
        }

        session()->flash('success', 'Event dan paket tiket berhasil dibuat!');
        return redirect()->route('owner.dashboard');
    }
};
?>

<div class="max-w-6xl mx-auto">
    <div class="mb-16">
        <h1 class="text-xs font-black uppercase tracking-[0.5em] text-slate-400 mb-4">New Event</h1>
        <h2 class="text-4xl font-black text-slate-800 tracking-tight leading-none">Create a new <br> <span
                class="italic font-serif font-light text-[#BD2636]">gathering</span>.</h2>
        <p class="mt-6 text-sm text-slate-500 max-w-sm font-medium uppercase tracking-tight">Define the architectural
            scope of your next gathering. Precision in detail creates an unforgettable experience.</p>
    </div>

    @if(session('success'))
        <div
            class="mb-8 p-6 bg-emerald-50 border border-emerald-100 rounded-[24px] text-emerald-700 text-xs font-black uppercase tracking-widest flex items-center gap-3">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                    clip-rule="evenodd" />
            </svg>
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit.prevent="store" class="grid grid-cols-1 lg:grid-cols-3 gap-16">

        {{-- ============ LEFT SIDE ============ --}}
        <div class="lg:col-span-2 space-y-16">

            {{-- Event Title --}}
            <div class="space-y-4">
                <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">Event Title</label>
                <input type="text" wire:model="title" required
                    class="w-full text-3xl font-black text-slate-800 placeholder:text-slate-200 border-b-2 border-slate-100 focus:border-[#BD2636] outline-none pb-4 transition bg-transparent"
                    placeholder="Make something great!">
                @error('title') <span class="text-red-500 text-[10px] uppercase font-bold">{{ $message }}</span> @enderror
            </div>

            {{-- Date & Time --}}
            <div class="grid grid-cols-2 gap-12">
                <div class="space-y-4">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">Start Date</label>
                    <input type="datetime-local" wire:model="start_date" required
                        class="w-full text-sm font-bold text-slate-800 border-b-2 border-slate-100 focus:border-[#BD2636] outline-none pb-4 transition bg-transparent">
                    @error('start_date') <span class="text-red-500 text-[10px] uppercase font-bold">{{ $message }}</span> @enderror
                </div>
                <div class="space-y-4">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">End Date</label>
                    <input type="datetime-local" wire:model="end_date" required
                        class="w-full text-sm font-bold text-slate-800 border-b-2 border-slate-100 focus:border-[#BD2636] outline-none pb-4 transition bg-transparent">
                    @error('end_date') <span class="text-red-500 text-[10px] uppercase font-bold">{{ $message }}</span> @enderror
                </div>
            </div>

            {{-- Description --}}
            <div class="space-y-4">
                <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">Description</label>
                <textarea wire:model="description" required rows="6"
                    class="w-full text-sm font-medium text-slate-800 placeholder:text-slate-300 border-b-2 border-slate-100 focus:border-[#BD2636] outline-none pb-4 transition bg-transparent leading-relaxed"
                    placeholder="Describe the atmosphere, the intent, and the architecture of your event..."></textarea>
                @error('description') <span class="text-red-500 text-[10px] uppercase font-bold">{{ $message }}</span> @enderror
            </div>

            {{-- Cover Image --}}
            <div class="space-y-4">
                <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">Event Cover Image</label>
                <div class="relative w-full aspect-[21/9] bg-[#F7F2E9] border-4 border-dashed border-[#F0EFEA] rounded-[40px] flex flex-col items-center justify-center group cursor-pointer overflow-hidden"
                    onclick="document.getElementById('image-input').click()">
                    @if ($image)
                        <div class="absolute inset-0">
                            <img src="{{ $image->temporaryUrl() }}" class="w-full h-full object-cover">
                        </div>
                    @endif
                    <div class="text-center relative z-10 transition group-hover:scale-110 duration-500 {{ $image ? 'opacity-0' : '' }}">
                        <div class="w-16 h-16 bg-[#BD2636] text-white rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-xl shadow-red-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 002-2H4a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h4 class="text-xs font-black uppercase tracking-[0.2em] text-[#BD2636]">Drop visuals here</h4>
                        <p class="text-[10px] font-bold text-slate-400 uppercase mt-2">Recommended: 1600x900px JPG or PNG</p>
                    </div>
                    <input type="file" wire:model="image" id="image-input" class="hidden" accept="image/*">
                </div>
                <div wire:loading wire:target="image" class="text-[10px] font-bold text-[#BD2636] uppercase">Uploading image...</div>
                @error('image') <span class="text-red-500 text-[10px] uppercase font-bold">{{ $message }}</span> @enderror
            </div>

            {{-- ======================================
                 TICKET PACKAGES SECTION
                 ====================================== --}}
            <div class="space-y-8">
                {{-- Section Header --}}
                <div class="flex items-end justify-between border-b-2 border-slate-100 pb-6">
                    <div>
                        <p class="text-[10px] font-black uppercase tracking-[0.4em] text-slate-300 mb-1">Tiket Event</p>
                        <h3 class="text-xl font-black text-slate-800 tracking-tight">Paket <span class="text-[#BD2636] italic font-serif font-light">Tiket</span></h3>
                    </div>
                    <button type="button" wire:click="addTicket"
                        class="flex items-center gap-2 px-5 py-2.5 bg-[#F7F2E9] text-[#8B7E66] text-[10px] font-black uppercase tracking-widest rounded-2xl hover:bg-[#EBE4D6] transition-all duration-200 active:scale-95">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4" />
                        </svg>
                        + Paket Baru
                    </button>
                </div>

                @error('tickets') <p class="text-red-500 text-[10px] uppercase font-bold -mt-4">{{ $message }}</p> @enderror

                {{-- Ticket Rows --}}
                <div class="space-y-6">
                    @foreach($tickets as $i => $ticket)
                        <div class="bg-[#FDFBF7] border border-slate-100 rounded-[32px] p-8 relative transition-all duration-300">

                            {{-- Row Header --}}
                            <div class="flex items-center justify-between mb-8">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-xl bg-[#BD2636]/10 flex items-center justify-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-[#BD2636]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 5v2m0 4v2m0 4v2M5 5a2 2 0 00-2 2v3a2 2 0 110 4v3a2 2 0 002 2h14a2 2 0 002-2v-3a2 2 0 110-4V7a2 2 0 00-2-2H5z" />
                                        </svg>
                                    </div>
                                    <span class="text-[10px] font-black uppercase tracking-[0.3em] text-slate-400">Paket #{{ $i + 1 }}</span>
                                </div>
                                @if(count($tickets) > 1)
                                    <button type="button" wire:click="removeTicket({{ $i }})"
                                        class="w-8 h-8 flex items-center justify-center rounded-full bg-red-50 text-red-400 hover:bg-red-100 hover:text-red-600 transition-all duration-200">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                @endif
                            </div>

                            <div class="space-y-8">
                                {{-- Nama Paket Tiket --}}
                                <div class="space-y-3">
                                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">Nama Paket Tiket</label>
                                    <input type="text"
                                        wire:model="tickets.{{ $i }}.name"
                                        class="w-full text-lg font-black text-slate-800 placeholder:text-slate-200 border-b-2 border-slate-100 focus:border-[#BD2636] outline-none pb-3 transition bg-transparent"
                                        placeholder="Contoh: VIP, Early Bird, Regular...">
                                    @error("tickets.$i.name") <span class="text-red-500 text-[10px] uppercase font-bold">{{ $message }}</span> @enderror
                                </div>

                                {{-- Deskripsi Benefit (desc) --}}
                                <div class="space-y-3">
                                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">Deskripsi Benefit</label>
                                    <textarea
                                        wire:model="tickets.{{ $i }}.desc"
                                        rows="3"
                                        class="w-full text-sm font-medium text-slate-700 placeholder:text-slate-300 border-b-2 border-slate-100 focus:border-[#BD2636] outline-none pb-3 transition bg-transparent leading-relaxed resize-none"
                                        placeholder="Contoh: Dapat snack dan kursi depan, akses backstage, dan merchandise eksklusif..."></textarea>
                                    @error("tickets.$i.desc") <span class="text-red-500 text-[10px] uppercase font-bold">{{ $message }}</span> @enderror
                                </div>

                                {{-- Price & Quota --}}
                                <div class="grid grid-cols-2 gap-8">
                                    {{-- Price (decimal 10,2) --}}
                                    <div class="space-y-3">
                                        <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">Harga Tiket (Rp)</label>
                                        <div class="flex items-center gap-2 border-b-2 border-slate-100 focus-within:border-[#BD2636] pb-3 transition">
                                            <span class="text-sm font-bold text-slate-300 flex-shrink-0">Rp</span>
                                            <input type="number"
                                                wire:model="tickets.{{ $i }}.price"
                                                min="0"
                                                step="0.01"
                                                class="w-full text-sm font-black text-slate-800 placeholder:text-slate-300 outline-none bg-transparent"
                                                placeholder="0.00">
                                        </div>
                                        @error("tickets.$i.price") <span class="text-red-500 text-[10px] uppercase font-bold">{{ $message }}</span> @enderror
                                    </div>

                                    {{-- Quota (integer, nullable = unlimited) --}}
                                    <div class="space-y-3">
                                        <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">Kuota <span class="text-slate-300 font-bold normal-case">(Kosong = ∞)</span></label>
                                        <input type="number"
                                            wire:model="tickets.{{ $i }}.quota"
                                            min="1"
                                            step="1"
                                            class="w-full text-sm font-black text-slate-800 placeholder:text-slate-300 border-b-2 border-slate-100 focus:border-[#BD2636] outline-none pb-3 transition bg-transparent"
                                            placeholder="Tidak terbatas">
                                        @error("tickets.$i.quota") <span class="text-red-500 text-[10px] uppercase font-bold">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Add ticket hint --}}
                <p class="text-[10px] font-bold text-slate-300 uppercase tracking-widest text-center">
                    Kamu bisa menambahkan lebih dari satu paket tiket (VIP, Regular, dll.)
                </p>
            </div>
            {{-- ====== END TICKET PACKAGES ====== --}}

        </div>

        {{-- ============ RIGHT SIDE ============ --}}
        <div class="space-y-12">

            {{-- Location Picker with Nominatim Search --}}
            <div class="bg-[#F7F2E9] p-8 rounded-[40px] border border-slate-100/50 space-y-6" wire:ignore>
                <div>
                    <label class="text-[10px] font-black uppercase tracking-widest text-[#8B7E66] mb-4 block">Location</label>

                    {{-- Nominatim Search Input --}}
                    <div class="relative mb-4" id="search-wrapper">
                        <div class="flex items-center gap-2 bg-white border border-[#EBE4D6] focus-within:border-[#BD2636] rounded-xl px-3 py-2.5 transition">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-3.5 w-3.5 text-[#8B7E66] flex-shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                            <input type="text" id="location-search"
                                class="w-full text-xs font-bold text-[#5C5346] bg-transparent outline-none placeholder:text-[#C5B99A]"
                                placeholder="Cari nama kota, venue, atau alamat...">
                        </div>
                        <div id="search-results"
                            class="absolute top-full left-0 right-0 mt-1 bg-white rounded-xl border border-slate-100 shadow-xl z-50 hidden overflow-hidden max-h-52 overflow-y-auto">
                        </div>
                    </div>

                    {{-- Map --}}
                    <div class="relative rounded-3xl overflow-hidden h-44 border border-[#EBE4D6]/50">
                        <div id="map" class="h-full w-full z-10"></div>
                    </div>
                </div>

                {{-- Venue Name (visible label) --}}
                <div class="space-y-2">
                    <label class="text-[10px] font-black uppercase tracking-widest text-[#8B7E66]">Nama Venue / Alamat</label>
                    <input type="text" id="location-label"
                        class="w-full text-xs font-bold text-[#5C5346] bg-transparent border-b border-[#EBE4D6] focus:border-[#BD2636] outline-none pb-2 transition"
                        placeholder="Otomatis terisi atau ketik manual">
                </div>

                {{-- Hidden Livewire inputs --}}
                <input type="hidden" id="latitude-input" wire:model="latitude">
                <input type="hidden" id="longitude-input" wire:model="longitude">
                <input type="hidden" id="location-wire" wire:model="location">

                <p class="text-[10px] font-bold text-[#8B7E66]/60 italic uppercase" id="coord-display">
                    Cari lokasi atau klik peta untuk memasang pin
                </p>
            </div>

            {{-- Category --}}
            <div class="bg-[#E7F7EF] p-8 rounded-[40px] border border-slate-100/50">
                <label class="text-[10px] font-black uppercase tracking-widest text-[#4A7F66] mb-4 block">Category</label>

                {{-- Category Visual Picker --}}
                <div class="space-y-3">
                    @foreach($categories as $category)
                        <label class="flex items-center gap-3 cursor-pointer group">
                            <input type="radio"
                                wire:model="category_id"
                                value="{{ $category->id }}"
                                class="hidden peer"
                                id="cat-{{ $category->id }}">
                            <div class="flex items-center gap-3 w-full px-4 py-3 rounded-2xl border-2 border-transparent bg-white/60
                                        peer-checked:border-[#2D5A46] peer-checked:bg-white
                                        group-hover:bg-white transition-all duration-200">
                                <span class="text-xl leading-none">{{ $category->icon }}</span>
                                <div class="flex-1 min-w-0">
                                    <p class="text-xs font-black text-[#2D5A46] truncate">{{ $category->name }}</p>
                                    @if($category->description)
                                        <p class="text-[9px] text-[#4A7F66]/60 font-medium truncate mt-0.5">{{ $category->description }}</p>
                                    @endif
                                </div>
                                {{-- Color dot --}}
                                <div class="w-2.5 h-2.5 rounded-full flex-shrink-0" style="background-color: {{ $category->color }}"></div>
                            </div>
                        </label>
                    @endforeach
                </div>

                @error('category_id') <span class="text-red-500 text-[10px] uppercase font-bold mt-2 block">{{ $message }}</span> @enderror
            </div>

            {{-- Submit --}}
            <button type="submit"
                class="w-full py-6 btn-primary text-white text-[12px] font-black uppercase tracking-[0.4em] rounded-[40px] shadow-2xl shadow-red-200/50">
                <span wire:loading.remove wire:target="store">Publish Event</span>
                <span wire:loading wire:target="store">Publishing...</span>
            </button>
        </div>

    </form>
</div>

@script
<script>
    // ── MAP INIT ──────────────────────────────────────────────
    var map = L.map('map', {
        zoomControl: false,
        attributionControl: false
    }).setView([-6.2088, 106.8456], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

    var marker;

    function setPin(lat, lng, label) {
        if (marker) {
            marker.setLatLng([lat, lng]);
        } else {
            marker = L.marker([lat, lng]).addTo(map);
        }
        map.setView([lat, lng], 15);

        // Sync hidden inputs → Livewire
        $wire.set('latitude', lat);
        $wire.set('longitude', lng);

        document.getElementById('coord-display').textContent =
            'Lat: ' + lat.toFixed(6) + ', Lng: ' + lng.toFixed(6);

        if (label) {
            const locLabel = document.getElementById('location-label');
            locLabel.value = label;
            $wire.set('location', label);
        }
    }

    // Click on map to drop a pin manually
    map.on('click', function(e) {
        setPin(e.latlng.lat, e.latlng.lng, null);
    });

    // ── NOMINATIM SEARCH ──────────────────────────────────────
    let searchTimeout;
    const searchInput   = document.getElementById('location-search');
    const searchResults = document.getElementById('search-results');

    searchInput.addEventListener('input', function() {
        clearTimeout(searchTimeout);
        const q = this.value.trim();

        if (q.length < 3) {
            searchResults.classList.add('hidden');
            return;
        }

        searchTimeout = setTimeout(() => {
            fetch(
                `https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(q)}&limit=6&countrycodes=id`,
                { headers: { 'Accept-Language': 'id' } }
            )
            .then(res => res.json())
            .then(data => {
                searchResults.innerHTML = '';

                if (!data.length) {
                    searchResults.innerHTML =
                        '<div class="px-4 py-3 text-[10px] font-bold text-slate-400 uppercase tracking-widest">Lokasi tidak ditemukan</div>';
                    searchResults.classList.remove('hidden');
                    return;
                }

                data.forEach(item => {
                    const btn = document.createElement('button');
                    btn.type      = 'button';
                    btn.className = 'w-full text-left px-4 py-3 text-xs font-bold text-slate-700 hover:bg-[#F7F2E9] transition border-b border-slate-50 last:border-0 flex items-start gap-2';
                    btn.innerHTML = `
                        <span class="text-[#BD2636] flex-shrink-0 mt-0.5">📍</span>
                        <span class="leading-relaxed">${item.display_name}</span>`;
                    btn.addEventListener('click', () => {
                        const lat   = parseFloat(item.lat);
                        const lng   = parseFloat(item.lon);
                        const label = item.display_name;
                        setPin(lat, lng, label);
                        // Show short name in search box
                        searchInput.value = label.split(',')[0].trim();
                        searchResults.classList.add('hidden');
                    });
                    searchResults.appendChild(btn);
                });

                searchResults.classList.remove('hidden');
            })
            .catch(() => searchResults.classList.add('hidden'));
        }, 400);
    });

    // Close dropdown on outside click
    document.addEventListener('click', function(e) {
        if (!document.getElementById('search-wrapper').contains(e.target)) {
            searchResults.classList.add('hidden');
        }
    });

    // Sync venue name input → Livewire on change
    document.getElementById('location-label').addEventListener('input', function() {
        $wire.set('location', this.value);
    });
</script>
@endscript