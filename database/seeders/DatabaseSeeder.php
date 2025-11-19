<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Database\Seeders\UsersTableSeeder;
use Database\Seeders\CountryStateCitySeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        // Truncate tables
        DB::table('users')->truncate();
        DB::table('cities')->truncate();
        DB::table('states')->truncate();
        DB::table('countries')->truncate();

        // Enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
        $this->call(CountryStateCitySeeder::class);
        $this->call(UsersTableSeeder::class);
    }
}
