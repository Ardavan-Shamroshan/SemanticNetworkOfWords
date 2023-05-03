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
    public function run(): void {
        Word::query()->insert([
                ['word' => 'خورشید'],
                ['word' => 'کتاب'],
                ['word' => 'درخت'],
                ['word' => 'صیاد'],
                ['word' => 'مزرعه'],
                ['word' => 'عشق'],
                ['word' => 'فردوسی'],
                ['word' => 'کلام'],
                ['word' => 'زبان'],
                ['word' => 'پزشک'],
            ]
        );
    }
}
