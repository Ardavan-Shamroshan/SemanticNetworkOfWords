<?php

namespace Database\Seeders;

use App\Models\Word;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WordSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i <= 20; $i++) {
            Word::query()->create([
                'word' => \Ybazli\Faker\Facades\Faker::word(),
            ]);
        }
    }
}
