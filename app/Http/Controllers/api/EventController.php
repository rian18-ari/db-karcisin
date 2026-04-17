<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\event;
use App\Models\ticket_package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class EventController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'title' => "event list",
            'data' => event::all(),
            'message' => "success"
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validasi
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required',
            'category_id' => 'required|exists:categories,id',
            'location' => 'required',
            'latitude' => 'required',
            'longitude' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'image' => 'required',
            // Validasi untuk array tiket
            'tickets' => 'required|array|min:1',
            'tickets.*.name' => 'required|string',
            'tickets.*.price' => 'required|numeric',
            'tickets.*.quota' => 'required|integer',
        ]);

        // 2. Mulai Transaction
        DB::beginTransaction();

        try {
            // 3. Simpan Event
            $event = event::create([
                'title' => $request->title,
                'slug' => Str::slug($request->title) . '-' . Str::random(5),
                'description' => $request->description,
                'location' => $request->location,
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'image' => $request->image,
                'status' => $request->status ?? 'draft',
                'category_id' => $request->category_id,
                'user_id' => auth()->id(), // Gunakan auth id kalau sudah ada login
            ]);

            // 4. Simpan Tiket-tiketnya menggunakan relasi
            // Asumsi kamu sudah buat relasi 'tickets()' di model Event
            foreach ($request->tickets as $ticket) {
                $event->tickets()->create($ticket);
            }

            // 5. Commit kalau semua sukses
            DB::commit();

            return response()->json([
                'title' => 'event list',
                'message' => 'Event dan Tiket berhasil dibuat!', 
                'data' => $event->load('tickets')
            ], 201);

        } catch (\Exception $e) {
            // 6. Rollback kalau ada yang error
            DB::rollBack();
            return response()->json([
                'message' => 'Gagal simpan data', 
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $event = event::find($id);
        $ticket = ticket_package::where('event_id', $id)->get();

        return response()->json([
            'title' => "event list",
            'data' => $event,
            'ticket' => $ticket,
            'message' => "success"
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $event = event::find($id);

        $event->update($request->all());

        return response()->json([
            'title' => "event list",
            'data' => $event,
            'message' => "success"
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $event = event::find($id);

        $event->delete();

        return response()->json([
            'title' => "event list",
            'data' => $event,
            'message' => "success"
        ], 200);








    }
}
