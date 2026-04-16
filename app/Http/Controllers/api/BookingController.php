<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\bookings;
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
       $userId = Auth::user()->id; 

        $booking = bookings::create([
            'ticket_code'   => $this->generateUniqueTicketCode(),
            'event_id'      => $request->event_id,
            'user_id'       => $userId, // Masukkan ke sini
            'price'   => $request->price,
            'status'        => $request->status,
            'proof_of_payment' => $request->proof_of_payment, 
        ]);

        return response()->json([
            'title' => "booking list",
            'data' => $booking,
            'message' => "success"
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

        $booking->update($request->all());

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
