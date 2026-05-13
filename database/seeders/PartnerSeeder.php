<?php

namespace Database\Seeders;

use App\Models\Partners;
use Faker\Factory as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PartnerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        // Generate 5 data partner fiktif
        for ($i = 1; $i <= 5; $i++) {
            Partners::create([
                'name' => $faker->company(),
                'logo_url' => 'https://placehold.co/200x200?text=' . urlencode('Partner ' . $i),
            ]);
        }
    }
}
