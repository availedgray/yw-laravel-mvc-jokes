<?php

namespace Database\Seeders;

use App\Models\Joke;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class JokeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Joke::factory()->count(88)->create();
    }
}
