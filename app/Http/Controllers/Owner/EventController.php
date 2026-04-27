<?php

namespace App\Http\Controllers\Owner;

use App\Http\Controllers\Controller;
use App\Models\event;
use App\Models\bookings;
use App\Models\categories;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class EventController extends Controller
{
    /**
     * Show form to create event.
     */
    public function create()
    {
        $categories = categories::all();
        return view('owner.events.create', compact('categories'));
    }

    /**
     * Store new event.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'location' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'category_id' => 'required|exists:categories,id',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $file = $request->file('image');
            $fileName = time() . '_' . Str::slug($request->title) . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('events'), $fileName);
            $imagePath = 'events/' . $fileName;
        }

        event::create([
            'title' => $request->title,
            'slug' => Str::slug($request->title) . '-' . Str::random(5),
            'description' => $request->description,
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'location' => $request->location,
            'start_date' => $request->start_date,
            'end_date' => $request->end_date,
            'category_id' => $request->category_id,
            'image' => $imagePath,
            'user_id' => auth()->id(),
            'status' => 'published',
        ]);

        return redirect()->route('owner.bookings.index')->with('success', 'Event successfully created!');
    }

    /**
     * List all participants (bookings).
     */
    public function participants()
    {
        $bookings = bookings::with(['user', 'ticketPackage.event'])
            ->latest()
            ->get();

        return view('owner.bookings.index', compact('bookings'));
    }

    /**
     * Validate/Check-in participant.
     */
    public function checkIn($id)
    {
        $booking = bookings::findOrFail($id);

        $booking->update([
            'check_in_at' => now(),
            'status' => 'used'
        ]);

        return redirect()->back()->with('success', 'Participant checked in successfully!');
    }
}
