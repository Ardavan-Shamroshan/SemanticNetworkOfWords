<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Word;
use Illuminate\Database\Seeder;
use Ybazli\Faker\Faker;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void {
        // \App\Models\User::factory(10)->create();

        \App\Models\User::factory()->create([
            'name'      => 'Admin',
            'email'     => 'admin@ut.com',
            'password'  => bcrypt('password'),
            'user_type' => 'admin',
        ]);
        \App\Models\User::factory()->create([
            'name'      => 'Kosar',
            'email'     => 'kosar@gmail.com',
            'password'  => bcrypt('password'),
            'user_type' => 'user',
        ]);

        $this->call([
            WordSeeder::class,
        ]);
    }
}
