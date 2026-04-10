<?php

namespace Database\Seeders;

use App\Models\Booking;
use App\Models\bookings;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seeder ini mengasumsikan UserSeeder dan EventSeeder sudah dijalankan.
        // User atender: Siti=2, Andi=3. Event: Festival Musik=1, Futsal=2, Tech Summit=3.

        bookings::insert([
            [
                'ticket_code' => 'TKT-001-' . strtoupper(substr(md5('booking1'), 0, 8)),
                'status' => 'paid',
                'price' => 150000.00,
                'proof_of_payment' => 'payments/bukti-transfer-1.jpg',
                'check_in_at' => null,
                'event_id' => 1,
                'user_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ticket_code' => 'TKT-002-' . strtoupper(substr(md5('booking2'), 0, 8)),
                'status' => 'pending',
                'price' => 50000.00,
                'proof_of_payment' => 'payments/bukti-transfer-2.jpg',
                'check_in_at' => null,
                'event_id' => 2,
                'user_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ticket_code' => 'TKT-003-' . strtoupper(substr(md5('booking3'), 0, 8)),
                'status' => 'used',
                'price' => 250000.00,
                'proof_of_payment' => 'payments/bukti-transfer-3.jpg',
                'check_in_at' => now(),
                'event_id' => 3,
                'user_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
