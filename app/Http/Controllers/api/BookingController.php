<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\bookings;
use App\Models\ticket_package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function __construct()
    {
        // Menggunakan static property sesuai library Midtrans PHP
        Config::$serverKey = Config('services.midtrans.server_key');
        Config::$clientKey = Config('services.midtrans.client_key');
        Config::$isProduction = Config('services.midtrans.is_production');
        Config::$isSanitized = Config('services.midtrans.is_sanitized');
        Config::$is3ds = Config('services.midtrans.is_3ds');
    }

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

        DB::beginTransaction();
        try {

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
                'payment_status' => 'pending',
            ]);

            // 6. Generate Snap Token Midtrans
            $orderId = 'KRC-' . $booking->id . '-' . time();
            
            $params = [
                'transaction_details' => [
                    'order_id' => $orderId,
                    'gross_amount' => $totalPrice,
                ],
                'customer_details' => [
                    'first_name' => auth()->user()->name,
                    'email' => auth()->user()->email,
                ],
            ];

            $snapToken = Snap::getSnapToken($params);

            // Update booking dengan snap_token
            $booking->update([
                'snap_token' => $snapToken
            ]);

            // 7. Kurangi kuota tiket (Logic dasar)
            $package->decrement('quota', $validated['quantity']);

            DB::commit();

            return response()->json([
                'title' => 'Success',
                'message' => 'Booking berhasil dibuat',
                'snap_token' => $snapToken,
                'data' => $booking
            ], 201);
        } catch (Exception $e) {
            DB::rollBack();
            return response()->json([
                'title' => 'Failed',
                'message' => 'Booking gagal dibuat',
                'error' => $e->getMessage()
            ], 500);
        }
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

    /**
     * Handle Midtrans Webhook Notification
     */
    public function webhook(Request $request)
    {
        $serverKey = config('services.midtrans.server_key');
        
        $orderId = $request->order_id;
        $statusCode = $request->status_code;
        $grossAmount = $request->gross_amount;
        $signatureKey = $request->signature_key;
        $transactionStatus = $request->transaction_status;
        
        // Verifikasi signature key
        $hashed = hash("sha512", $orderId . $statusCode . $grossAmount . $serverKey);
        
        if ($hashed == $signatureKey) {
            // order_id format: KRC-{id}-{timestamp}
            $orderIdParts = explode('-', $orderId);
            $bookingId = $orderIdParts[1] ?? null;
            
            if ($bookingId) {
                $booking = bookings::find($bookingId);
                
                if ($booking) {
                    if ($transactionStatus == 'capture' || $transactionStatus == 'settlement') {
                        $booking->update(['payment_status' => 'success']);
                    } elseif ($transactionStatus == 'cancel' || $transactionStatus == 'deny') {
                        $booking->update(['payment_status' => 'cancel']);
                    } elseif ($transactionStatus == 'expire') {
                        $booking->update(['payment_status' => 'expire']);
                    } elseif ($transactionStatus == 'pending') {
                        $booking->update(['payment_status' => 'pending']);
                    }
                }
            }
        }
        
        return response()->json(['message' => 'Webhook received']);
    }
}
