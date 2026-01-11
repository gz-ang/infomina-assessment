<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MembershipPlan;

class MembershipPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Check if membership plans exist
        if (MembershipPlan::count() === 0) {
            MembershipPlan::insert([
                [
                    'name' => 'Free Trial',
                    'description' => 'Free trial for one week',
                    'price' => 0,
                    'validity_type' => 'week',
                    'validity' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => '90D Trial',
                    'description' => 'Enjoy 90 days trial at extremely low price',
                    'price' => 10,
                    'validity_type' => 'day',
                    'validity' => 90,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Monthly',
                    'description' => 'Monthly membership',
                    'price' => 40,
                    'validity_type' => 'month',
                    'validity' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Quarterly',
                    'description' => 'Quarterly membership',
                    'price' => 60,
                    'validity_type' => 'month',
                    'validity' => 3,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'name' => 'Annual',
                    'description' => 'Annual membership',
                    'price' => 200,
                    'validity_type' => 'year',
                    'validity' => 1,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            ]);
        }
    }
}
