<?php

namespace Database\Seeders;

use App\Models\Member;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MemberSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Member::factory(50)->create();
        sleep(1);
        Member::factory()->create([
            'membership_plan_id' => 4,
            'start_date' => now()->subMonths(1)->toDateString(),
            'end_date' => now()->addMonths(2)->toDateString(),
        ]);
        sleep(1);
        Member::factory()->create([
            'membership_plan_id' => 2,
            'start_date' => now()->addWeek()->toDateString(),
            'end_date' => now()->addWeek()->addDays(90)->toDateString(),
        ]);
    }
}
