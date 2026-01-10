<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\MembershipPlanSeeder;
use Database\Seeders\MemberSeeder;
use App\Models\User;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(MembershipPlanSeeder::class);
        $this->call(MemberSeeder::class);

        // Creates admin user
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => bcrypt('P@$$W0rd!'),
        ]);
    }
}
