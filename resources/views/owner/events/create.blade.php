@extends('layouts.owner')

@section('content')
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-slate-800">Create New Event</h1>
        <p class="text-slate-500">Fill in the details to host a new event on Karcis.in</p>
    </div>

    @if(session('success'))
        <div
            class="mb-6 p-4 bg-emerald-100 border border-emerald-200 text-emerald-700 rounded-xl flex items-center gap-3 animate-pulse">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                    clip-rule="evenodd" />
            </svg>
            {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('owner.events.store') }}" method="POST" enctype="multipart/form-data"
        class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        @csrf
        <div class="lg:col-span-2 space-y-6">
            <!-- Basic Info -->
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100 space-y-4">
                <h2 class="text-xl font-semibold mb-4 flex items-center gap-2">
                    <span
                        class="w-8 h-8 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center text-sm">1</span>
                    Event Information
                </h2>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Event Title</label>
                    <input type="text" name="title" required
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition"
                        placeholder="Ex: Summer Music Festival 2026">
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Description</label>
                    <textarea name="description" rows="4" required
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition"
                        placeholder="Tell people about your event..."></textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Start Date</label>
                        <input type="datetime-local" name="start_date" required
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">End Date</label>
                        <input type="datetime-local" name="end_date" required
                            class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition">
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Category</label>
                    <select name="category_id" required
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition">
                        @foreach($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <!-- Location -->
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100 space-y-4">
                <h2 class="text-xl font-semibold mb-4 flex items-center gap-2">
                    <span
                        class="w-8 h-8 rounded-lg bg-indigo-100 text-indigo-600 flex items-center justify-center text-sm">2</span>
                    Location Details
                </h2>

                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-1">Venue Name / Address</label>
                    <input type="text" name="location" id="location_name" required
                        class="w-full px-4 py-3 rounded-xl border border-slate-200 focus:ring-2 focus:ring-indigo-500 focus:border-transparent outline-none transition"
                        placeholder="Ex: Gelora Bung Karno, Jakarta">
                </div>

                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Latitude</label>
                        <input type="text" name="latitude" id="latitude" readonly required
                            class="w-full px-4 py-3 rounded-xl border border-slate-100 bg-slate-50 cursor-not-allowed">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Longitude</label>
                        <input type="text" name="longitude" id="longitude" readonly required
                            class="w-full px-4 py-3 rounded-xl border border-slate-100 bg-slate-50 cursor-not-allowed">
                    </div>
                </div>

                <div class="relative">
                    <p class="text-xs text-slate-500 mb-2 italic">Click on the map to pin your event location</p>
                    <div id="map" class="h-80 rounded-2xl border border-slate-200 z-10"></div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <div class="bg-white p-8 rounded-2xl shadow-sm border border-slate-100">
                <h2 class="text-xl font-semibold mb-4">Media</h2>
                <div class="space-y-4">
                    <label class="block text-sm font-medium text-slate-700 mb-1">Event Banner</label>
                    <div class="relative border-2 border-dashed border-slate-200 rounded-2xl p-6 flex flex-col items-center justify-center bg-slate-50 hover:bg-slate-100 transition cursor-pointer group"
                        onclick="document.getElementById('image-input').click()">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-10 w-10 text-slate-400 group-hover:text-indigo-500 transition mb-2" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 002-2H4a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <p class="text-sm text-slate-500 text-center">Click or drag image to upload</p>
                        <input type="file" name="image" id="image-input" class="hidden" accept="image/*"
                            onchange="previewImage(event)">
                        <img id="image-preview" class="hidden mt-4 w-full h-40 object-cover rounded-xl border">
                    </div>
                </div>
            </div>

            <button type="submit"
                class="w-full py-4 px-6 bg-gradient-to-r from-indigo-600 to-violet-600 text-white font-bold rounded-2xl shadow-lg shadow-indigo-200 hover:shadow-indigo-300 transform hover:-translate-y-1 transition-all duration-300">
                Publish Event
            </button>
        </div>
    </form>
@endsection

@push('scripts')
    <script>
        // Leaflet.js Implementation
        var map = L.map('map').setView([-6.2088, 106.8456], 13); // Default Jakarta

        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; OpenStreetMap contributors'
        }).addTo(map);

        var marker;

        map.on('click', function (e) {
            var lat = e.latlng.lat;
            var lng = e.latlng.lng;

            if (marker) {
                marker.setLatLng(e.latlng);
            } else {
                marker = L.marker(e.latlng).addTo(map);
            }

            document.getElementById('latitude').value = lat;
            document.getElementById('longitude').value = lng;
        });

        function previewImage(event) {
            var reader = new FileReader();
            reader.onload = function () {
                var output = document.getElementById('image-preview');
                output.src = reader.result;
                output.classList.remove('hidden');
            }
            reader.readAsDataURL(event.target.files[0]);
        }
    </script>
@endpush