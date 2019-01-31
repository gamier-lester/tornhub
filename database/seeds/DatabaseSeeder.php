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
            'name' => 'available',
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
    }
}
