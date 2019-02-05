<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('statuses')->insert([
            'name' => 'active',
        ]);
        DB::table('statuses')->insert([
            'name' => 'suspended',
        ]);
        DB::table('statuses')->insert([
            'name' => 'pending',
        ]);
        DB::table('statuses')->insert([
            'name' => 'approved',
        ]);
        DB::table('statuses')->insert([
            'name' => 'not available',
        ]);
        DB::table('statuses')->insert([
            'name' => 'pickup',
        ]);
        DB::table('statuses')->insert([
            'name' => 'returned',
        ]);
        DB::table('statuses')->insert([
            'name' => 'available',
        ]);
        DB::table('statuses')->insert([
            'name' => 'received',
        ]);
        DB::table('roles')->insert([
            'name' => 'user',
        ]);
        DB::table('roles')->insert([
            'name' => 'staff',
        ]);
        DB::table('roles')->insert([
            'name' => 'admin',
        ]);
        DB::table('users')->insert([
            'email' => 'gamier.lester@gmail.com',
            'firstname' => 'lester',
            'lastname' => 'gamier',
            'address' => 'pogi street',
            'image_path' => 'na',
            'password' => '$2y$10$peTnK3/Arb.4O7cH3hCwYO5lFWZ..7sIByZ98HM2LcXRjvJ41O3Xy',
            'account_status' => 1,
            'account_role' => 1,
            'remember_token' => 'a17LkUcAQ9vkiZdbr21FExzeReau0VFmElVC8fzhoAStVNsy6SutHG4et6mu',
            'created_at' => '2019-01-29 05:51:45', 
            'updated_at' => '2019-01-29 05:51:45',
        ]);
    }
}
