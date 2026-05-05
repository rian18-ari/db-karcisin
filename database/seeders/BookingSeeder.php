<?php

namespace Database\Seeders;

use App\Models\bookings;
use Illuminate\Database\Seeder;

class BookingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seeder ini mengasumsikan UserSeeder dan EventSeeder (beserta TicketPackage) sudah dijalankan.
        // User: Siti=2, Andi=3.
        // Ticket packages: Regular Musik=1, VIP Musik=2, Regular Futsal=3, Regular Tech=4, Early Bird Tech=5.

        bookings::insert([
            [
                'ticket_code' => 'TKT-001-' . strtoupper(substr(md5('booking1'), 0, 8)),
                'status' => 'paid',
                'price' => 150000.00,
                'check_in_at' => null,
                'ticket_package_id' => 1,
                'user_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ticket_code' => 'TKT-002-' . strtoupper(substr(md5('booking2'), 0, 8)),
                'status' => 'pending',
                'price' => 50000.00,
                'check_in_at' => null,
                'ticket_package_id' => 3,
                'user_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'ticket_code' => 'TKT-003-' . strtoupper(substr(md5('booking3'), 0, 8)),
                'status' => 'used',
                'price' => 250000.00,
                'check_in_at' => now(),
                'ticket_package_id' => 4,
                'user_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
