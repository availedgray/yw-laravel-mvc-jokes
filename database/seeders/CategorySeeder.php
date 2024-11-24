<?php
namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::create([
            'name' => 'Comedy',
        ]);

        Category::create([
            'name' => 'Drama',
        ]);

        Category::create([
            'name' => 'Dad',
        ]);

        Category::create([
            'name' => 'Dummy',
        ]);

        Category::create([
            'name' => 'Tech',
        ]);

        Category::create([
            'name' => 'Pet',
        ]);

        Category::create([
            'name' => 'Short',
        ]);

        Category::create([
            'name' => 'Long',
        ]);
    }
}
