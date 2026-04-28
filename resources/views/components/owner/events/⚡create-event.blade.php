<?php

use Livewire\Volt\Component;
use Livewire\WithFileUploads;
use App\Models\event;
use App\Models\categories;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

new class extends Component {
    use WithFileUploads;

    public $title;
    public $description;
    public $start_date;
    public $end_date;
    public $location;
    public $latitude;
    public $longitude;
    public $category_id;
    public $price;
    public $image;

    public function with(): array
    {
        return [
            'categories' => categories::all(),
        ];
    }

    public function mount()
    {
        $this->category_id = categories::first()?->id;
    }

    public function store()
    {
        $this->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'location' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'category_id' => 'required|exists:categories,id',
            'image' => 'required|image|max:2048',
        ]);

        $imageName = time() . '_' . Str::slug($this->title) . '.' . $this->image->getClientOriginalExtension();
        $this->image->storeAs('events', $imageName, 'public');
        $imagePath = 'events/' . $imageName;

        event::create([
            'title' => $this->title,
            'slug' => Str::slug($this->title) . '-' . Str::random(5),
            'description' => $this->description,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'location' => $this->location,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'category_id' => $this->category_id,
            'image' => $imagePath,
            'user_id' => Auth::id(),
            'status' => 'published',
        ]);

        session()->flash('success', 'Event successfully created!');
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
        <!-- Left Side: Main Form -->
        <div class="lg:col-span-2 space-y-16">
            <!-- Event Title -->
            <div class="space-y-4">
                <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">Event Title</label>
                <input type="text" wire:model="title" required
                    class="w-full text-3xl font-black text-slate-800 placeholder:text-slate-200 border-b-2 border-slate-100 focus:border-[#BD2636] outline-none pb-4 transition bg-transparent"
                    placeholder="Make something great!">
                @error('title') <span class="text-red-500 text-[10px] uppercase font-bold">{{ $message }}</span>
                @enderror
            </div>

            <!-- Date & Time -->
            <div class="grid grid-cols-2 gap-12">
                <div class="space-y-4">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">Start Date</label>
                    <input type="datetime-local" wire:model="start_date" required
                        class="w-full text-sm font-bold text-slate-800 border-b-2 border-slate-100 focus:border-[#BD2636] outline-none pb-4 transition bg-transparent">
                </div>
                <div class="space-y-4">
                    <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">End Date</label>
                    <input type="datetime-local" wire:model="end_date" required
                        class="w-full text-sm font-bold text-slate-800 border-b-2 border-slate-100 focus:border-[#BD2636] outline-none pb-4 transition bg-transparent">
                </div>
            </div>

            <!-- Description -->
            <div class="space-y-4">
                <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">Description</label>
                <textarea wire:model="description" required rows="6"
                    class="w-full text-sm font-medium text-slate-800 placeholder:text-slate-300 border-b-2 border-slate-100 focus:border-[#BD2636] outline-none pb-4 transition bg-transparent leading-relaxed"
                    placeholder="Describe the atmosphere, the intent, and the architecture of your event..."></textarea>
            </div>

            <!-- Cover Image Upload Area -->
            <div class="space-y-4">
                <label class="text-[10px] font-black uppercase tracking-widest text-slate-400">Event Cover Image</label>
                <div class="relative w-full aspect-[21/9] bg-[#F7F2E9] border-4 border-dashed border-[#F0EFEA] rounded-[40px] flex flex-col items-center justify-center group cursor-pointer overflow-hidden"
                    onclick="document.getElementById('image-input').click()">

                    @if ($image)
                        <div class="absolute inset-0">
                            <img src="{{ $image->temporaryUrl() }}" class="w-full h-full object-cover">
                        </div>
                    @endif

                    <div
                        class="text-center relative z-10 transition group-hover:scale-110 duration-500 {{ $image ? 'opacity-0' : '' }}">
                        <div
                            class="w-16 h-16 bg-[#BD2636] text-white rounded-2xl flex items-center justify-center mx-auto mb-6 shadow-xl shadow-red-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 002-2H4a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h4 class="text-xs font-black uppercase tracking-[0.2em] text-[#BD2636]">Drop visuals here</h4>
                        <p class="text-[10px] font-bold text-slate-400 uppercase mt-2">Recommended: 1600x900px JPG or
                            PNG</p>
                    </div>
                    <input type="file" wire:model="image" id="image-input" class="hidden" accept="image/*">
                </div>
                <div wire:loading wire:target="image" class="text-[10px] font-bold text-[#BD2636] uppercase">Uploading
                    image...</div>
            </div>
        </div>

        <!-- Right Side: Sidebar Controls -->
        <div class="space-y-12">
            <!-- Location Picker -->
            <div class="bg-[#F7F2E9] p-8 rounded-[40px] border border-slate-100/50 space-y-6">
                <div>
                    <label
                        class="text-[10px] font-black uppercase tracking-widest text-[#8B7E66] mb-4 block">Location</label>
                    <input type="text" wire:model.defer="location" required
                        class="w-full text-xs font-bold text-[#5C5346] bg-transparent border-b border-[#EBE4D6] focus:border-[#BD2636] outline-none pb-2 transition"
                        placeholder="Venue Name or Address">
                </div>

                <div class="relative rounded-3xl overflow-hidden h-40 border border-[#EBE4D6]/50" wire:ignore>
                    <div id="map" class="h-full w-full z-10"></div>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <input type="hidden" id="latitude" wire:model="latitude">
                    <input type="hidden" id="longitude" wire:model="longitude">
                    <p class="text-[10px] font-bold text-[#8B7E66]/60 italic uppercase">Click on map to pin</p>
                </div>
            </div>

            <!-- Category -->
            <div class="bg-[#E7F7EF] p-8 rounded-[40px] border border-slate-100/50">
                <label
                    class="text-[10px] font-black uppercase tracking-widest text-[#4A7F66] mb-4 block">Category</label>
                <select wire:model="category_id" required
                    class="w-full text-xs font-bold text-[#2D5A46] bg-transparent border-b border-[#D1EBE0] focus:border-[#4A7F66] outline-none pb-2 transition appearance-none cursor-pointer">
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Price -->
            <div class="bg-[#FDFBF7] p-8 rounded-[40px] border border-slate-100 border-dashed">
                <label
                    class="text-[10px] font-black uppercase tracking-widest text-slate-400 mb-4 block text-center">Ticket
                    Price</label>
                <div class="flex items-center justify-center gap-2">
                    <span class="text-xl font-bold text-slate-300">Rp.</span>
                    <input type="number" wire:model="price" step="0.01"
                        class="w-24 text-center text-3xl font-black text-slate-800 bg-transparent border-b-2 border-slate-100 focus:border-[#BD2636] outline-none transition"
                        placeholder="0">
                </div>
            </div>

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
    var map = L.map('map', {
        zoomControl: false,
        attributionControl: false
    }).setView([-6.2088, 106.8456], 13);

    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png').addTo(map);

    var marker;

    map.on('click', function  (e) {
        var lat = e.latlng.lat;
        var lng = e.latlng.lng;

        if (marker) {
            marker.setLatLng(e.latlng);
        } else {
            marker = L.marker(e.latlng).addTo(map);
        }

        $wire.set('latitude', lat);
        $wire.set('longitude', lng);
    });
</script>
@endscript