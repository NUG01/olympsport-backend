<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Category;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        DB::unprepared(file_get_contents(__DIR__ . '/cities.sql'));


        $json = public_path('categories.json');
        $file = file_get_contents($json);

        foreach (json_decode($file) as $item) {
            Category::create([
                'id' => $item->id,
                'name' => $item->name,
                'slug' => $item->slug,
                'parent_id' => $item->parent_id,
            ]);
        }

    }
}
