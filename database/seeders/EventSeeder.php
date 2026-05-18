<?php

namespace Database\Seeders;

use App\Models\Event;
use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil semua kategori yang sudah ada
        $categories = Category::all();

        // Data event template untuk setiap kategori
        $eventTemplates = [
            'Seminar IT' => [
                'title' => 'Seminar Cloud Computing 2026',
                'description' => 'Pelajari teknologi cloud computing terkini dari para ahli industri.',
                'location' => 'Auditorium Utama Amikom',
                'price' => 200000,
                'stock' => 300,
            ],
            'Entertaiment' => [
                'title' => 'Comedy Night - Stand Up Show',
                'description' => 'Malam seru bersama komika ternama dengan pertunjukan yang penuh tawa.',
                'location' => 'Theater Amikom',
                'price' => 150000,
                'stock' => 500,
            ],
            'Workshop' => [
                'title' => 'Web Development Workshop',
                'description' => 'Workshop praktis membuat website modern dengan HTML, CSS, dan JavaScript.',
                'location' => 'Lab Komputer Amikom',
                'price' => 250000,
                'stock' => 80,
            ],
            'Olahraga' => [
                'title' => 'Marathon Amikom 2026',
                'description' => 'Lari marathon 5K dan 10K dengan peserta dari berbagai kalangan.',
                'location' => 'Lapangan Olahraga Amikom',
                'price' => 100000,
                'stock' => 1000,
            ],
            'Bisnis' => [
                'title' => 'Startup Pitching Event',
                'description' => 'Platform bagi entrepreneur muda untuk mempresentasikan ide bisnis mereka.',
                'location' => 'Innovation Center Amikom',
                'price' => 180000,
                'stock' => 200,
            ],
        ];

        // Buat event untuk setiap kategori
        foreach ($categories as $category) {
            if (isset($eventTemplates[$category->name])) {
                $template = $eventTemplates[$category->name];
                
                Event::create([
                    'category_id' => $category->id,
                    'title' => $template['title'],
                    'description' => $template['description'],
                    'date' => now()->addDays(rand(7, 45))->setHour(rand(10, 18))->setMinute(0),
                    'location' => $template['location'],
                    'price' => $template['price'],
                    'stock' => $template['stock'],
                    'poster_path' => 'https://placehold.co/400x600',
                ]);
            }
        }
    }
}
