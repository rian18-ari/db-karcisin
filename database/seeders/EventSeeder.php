<?php

namespace Database\Seeders;

use App\Models\event;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Seeder ini mengasumsikan UserSeeder dan CategorySeeder sudah dijalankan.
        // User owner memiliki ID 1, category: Musik=1, Olahraga=2, Teknologi=3.

        event::insert([
            [
                'title' => 'Festival Musik Jakarta 2026',
                'slug' => 'festival-musik-jakarta-2026',
                'description' => 'Konser musik terbesar di Jakarta yang menampilkan berbagai artis ternama nasional dan internasional.',
                'quota' => 500,
                'latitude' => -6.20876200,
                'longitude' => 106.84561700,
                'location' => 'Gelora Bung Karno, Jakarta',
                'start_date' => '2026-05-10 18:00:00',
                'end_date' => '2026-05-10 23:00:00',
                'price' => 150000.00,
                'status' => 'published',
                'image' => 'events/festival-musik.jpg',
                'category_id' => 1,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Turnamen Futsal Piala Nusantara',
                'slug' => 'turnamen-futsal-piala-nusantara',
                'description' => 'Turnamen futsal antar klub se-Indonesia memperebutkan trofi bergengsi Piala Nusantara.',
                'quota' => 200,
                'latitude' => -7.28274400,
                'longitude' => 112.75208700,
                'location' => 'GOR Dyandra, Surabaya',
                'start_date' => '2026-06-15 08:00:00',
                'end_date' => '2026-06-15 17:00:00',
                'price' => 50000.00,
                'status' => 'published',
                'image' => 'events/turnamen-futsal.jpg',
                'category_id' => 2,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Tech Summit Indonesia 2026',
                'slug' => 'tech-summit-indonesia-2026',
                'description' => 'Konferensi teknologi terkemuka yang mempertemukan para inovator, developer, dan pelaku industri digital.',
                'quota' => 300,
                'latitude' => -6.91747900,
                'longitude' => 107.61912500,
                'location' => 'Trans Convention Center, Bandung',
                'start_date' => '2026-07-20 09:00:00',
                'end_date' => '2026-07-21 17:00:00',
                'price' => 250000.00,
                'status' => 'draft',
                'image' => 'events/tech-summit.jpg',
                'category_id' => 3,
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
