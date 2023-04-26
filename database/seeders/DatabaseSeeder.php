<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\enums\Role;
use App\Models\Category;
use App\Models\Plan;
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

        \App\Models\User::factory()->create([
            'first_name' => 'admin',
            'last_name' => 'adminiani',
            'username' => 'admina69',
            'email' => 'admin@gmail.com',
            'phone_number' => '+995 555 555 555',
            'password' => bcrypt('Admin123'),
            'verification_code' => sha1(time()),
            'role' => Role::ADMIN->value,
            'city' => 1,
            'email_verified_at' => now(),
        ]);

        DB::unprepared(file_get_contents(__DIR__ . '/cities.sql'));

        $json = __DIR__ . '/categories.json';
        $file = file_get_contents($json);

        foreach (json_decode($file) as $item) {
            Category::create([
                'id' => $item->id,
                'name' => $item->name,
                'slug' => $item->slug,
                'parent_id' => $item->parent_id,
            ]);
        }

        DB::table('website_assets')->insert(['website_text' => 'terms and conditions']);
        DB::table('website_assets')->insert(['website_text' => 'about us']);
    }
}
