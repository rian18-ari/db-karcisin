<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\bookings;
use App\Models\ticket_package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */


    public function generateUniqueTicketCode()
    {
        do {
            // Generate kode acak 8 karakter, diubah ke huruf kapital
            // Contoh hasil: K7J9A2LP
            $code = Str::upper(Str::random(8));
        } while (bookings::where('ticket_code', $code)->exists());
        // Looping terus selama kode sudah ada di database (untuk menjamin keunikan)

        return $code;
    }
    public function index(Request $request)
    {
        $user_id = Auth::user()->id;
        $booking = bookings::where('user_id', $user_id)
            ->with('event')
            ->get();

        return response()->json([
            'title' => "booking list",
            'data' => $booking->isEmpty() ? "data masih kosong" : $booking,
            'message' => "success"
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validasi input
        $validated = $request->validate([
            'ticket_package_id' => 'required|exists:ticket_packages,id',
            'quantity' => 'required|integer|min:1',
        ]);

        // 2. Ambil data paket tiket untuk cek kuota dan harga
        $package = ticket_package::findOrFail($validated['ticket_package_id']);

        // 3. (Opsional tapi Penting) Cek apakah kuota masih tersedia
        if ($package->quota < $validated['quantity']) {
            return response()->json(['message' => 'Kuota tiket tidak mencukupi'], 400);
        }

        // 4. Hitung total harga
        $totalPrice = $package->price * $validated['quantity'];

        // 5. Simpan booking
        $booking = bookings::create([
            'user_id' => auth()->id(), // Ambil ID user yang sedang login via Sanctum
            'ticket_code' => $this->generateUniqueTicketCode(),
            'ticket_package_id' => $validated['ticket_package_id'],
            'price' => $totalPrice,
            'status' => 'pending', // Status awal selalu pending
        ]);

        // 6. Kurangi kuota tiket (Logic dasar)
        $package->decrement('quota', $validated['quantity']);

        return response()->json([
            'title' => 'Success',
            'message' => 'Booking berhasil dibuat',
            'data' => $booking
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $booking = bookings::find($id);

        return response()->json([
            'title' => "booking list",
            'data' => $booking,
            'message' => "success"
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $booking = bookings::find($id);

        $booking->update([
            'check_in_at' => now(),
            'status' => 'used'
        ]);

        return response()->json([
            'title' => "booking list",
            'data' => $booking,
            'message' => "success"
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $booking = bookings::find($id);

        $booking->delete();

        return response()->json([
            'title' => "booking list",
            'data' => $booking,
            'message' => "success"
        ], 200);
    }
}
