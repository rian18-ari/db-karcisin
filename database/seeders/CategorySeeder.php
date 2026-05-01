<?php

namespace Database\Seeders;

use App\Models\categories;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name'        => 'Musik',
                'slug'        => 'musik',
                'icon'        => '🎵',
                'color'       => '#7C3AED',
                'description' => 'Konser, festival musik, pertunjukan band, dan semua acara bertema musik.',
            ],
            [
                'name'        => 'Olahraga',
                'slug'        => 'olahraga',
                'icon'        => '⚽',
                'color'       => '#059669',
                'description' => 'Turnamen, kompetisi olahraga, lomba lari, dan kegiatan fisik lainnya.',
            ],
            [
                'name'        => 'Teknologi',
                'slug'        => 'teknologi',
                'icon'        => '💻',
                'color'       => '#2563EB',
                'description' => 'Konferensi tech, hackathon, workshop coding, dan seminar digital.',
            ],
            [
                'name'        => 'Seni & Budaya',
                'slug'        => 'seni-budaya',
                'icon'        => '🎨',
                'color'       => '#D97706',
                'description' => 'Pameran seni, pertunjukan teater, festival budaya, dan kesenian daerah.',
            ],
            [
                'name'        => 'Pendidikan',
                'slug'        => 'pendidikan',
                'icon'        => '📚',
                'color'       => '#0891B2',
                'description' => 'Seminar, workshop, pelatihan, dan kegiatan edukatif lainnya.',
            ],
            [
                'name'        => 'Kuliner',
                'slug'        => 'kuliner',
                'icon'        => '🍜',
                'color'       => '#DC2626',
                'description' => 'Festival makanan, bazar kuliner, cooking class, dan food expo.',
            ],
            [
                'name'        => 'Bisnis',
                'slug'        => 'bisnis',
                'icon'        => '💼',
                'color'       => '#374151',
                'description' => 'Konferensi bisnis, networking event, pameran dagang, dan forum investasi.',
            ],
            [
                'name'        => 'Hiburan',
                'slug'        => 'hiburan',
                'icon'        => '🎭',
                'color'       => '#BD2636',
                'description' => 'Stand-up comedy, variety show, games tournament, dan hiburan keluarga.',
            ],
        ];

        foreach ($categories as $category) {
            categories::updateOrCreate(
                ['slug' => $category['slug']],
                array_merge($category, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ])
            );
        }
    }
}
