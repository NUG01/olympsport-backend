<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\enums\Role;
use App\Models\Category;
use App\Models\Plan;
use App\Models\Subscription;
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

        $user1 = \App\Models\User::factory()->create([
            'first_name' => 'admin',
            'last_name' => 'adminiani',
            'username' => 'admina69',
            'email' => 'admin@gmail.com',
            'phone_number' => '+995 555 555 555',
            'password' => bcrypt('Admin123'),
            'verification_code' => sha1(time()),
            'role' => Role::ADMIN->value,
            'city' => 1,
            'stripe_id' => 'cus_NafCJZeLv7C0RZ',
            'email_verified_at' => now(),
        ]);

        $user2 = \App\Models\User::factory()->create([
            'first_name' => 'Seeker',
            'last_name' => 'Seekeriani',
            'username' => 'seeker',
            'email' => 'seeker@gmail.com',
            'phone_number' => '+995 555 555 555',
            'password' => bcrypt('Seeker123'),
            'verification_code' => sha1(time()),
            'role' => Role::SEEKER->value,
            'city' => 1,
            'stripe_id' => 'cus_Ngbua1uv8oXu5f',
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

        Subscription::create([
            'user_id' => $user1->id,
            'name' => 'Online TOTAL!',
            'stripe_id' => 'sub_1MpTs9LLLxBR1G3Rjc8L1paS',
            'stripe_status' => 'active',
            'stripe_price' => 'plan_N6MOhmJUwOIRQK',
            'quantity' => 1,
        ]);

        Subscription::create([
            'user_id' => $user2->id,
            'name' => 'Online TOTAL!',
            'stripe_id' => 'sub_1MpTs9LLLxBR1G3Rjc8L1paS',
            'stripe_status' => 'active',
            'stripe_price' => 'plan_N6MOhmJUwOIRQK',
            'quantity' => 1,
        ]);

        Plan::create([
            'id' => 1,
            'name' => 'Online TOTAL!',
            'duration' => 7,
            'cost' => 29.0,
            'interval' => 'week',
            'sale' => null,
            'details' => 'Entraînements illimités, Comprendre, Lire/Écrire & Parler, Apprenez grâce aux Corrections',
            'stripe_plan' => 'plan_N6MOhmJUwOIRQK',
        ]);

        DB::table('subscription_items')->insert([
            'subscription_id' => 1,
            'stripe_id' => 'si_NafCrfqls132Qf',
            'stripe_product' => 'prod_N6MODz7wBzQJKT',
            'stripe_price' => 'plan_N6MOhmJUwOIRQK',
            'quantity' => 1,
        ]);

        DB::table('subscription_items')->insert([
            'subscription_id' => 2,
            'stripe_id' => 'si_NafCrfqls132Qf',
            'stripe_product' => 'prod_N6MODz7wBzQJKT',
            'stripe_price' => 'plan_N6MOhmJUwOIRQK',
            'quantity' => 1,
        ]);

        DB::table('website_assets')->insert(['website_text' => 'terms and conditions']);
        DB::table('website_assets')->insert(['website_text' => 'about us']);
    }
}
