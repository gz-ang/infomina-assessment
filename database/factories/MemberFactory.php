<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Member>
 */
class MemberFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $membershipPlanId = fake()->numberBetween(1, 4);
        $startDate = Carbon::parse(fake()->date());
        $endDate = $startDate->copy();
        switch ($membershipPlanId) {
            case 1:
                $endDate->addDays(7);
                break;
            case 2:
                $endDate->addMonths(1);
                break;
            case 3:
                $endDate->addMonths(3);
                break;
            case 4:
                $endDate->addYears(1);
                break;
            default:
                $endDate->addMonths(1);
                break;
        }
        
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'date_of_birth' => fake()->date(),
            'membership_plan_id' => $membershipPlanId,
            'start_date' => $startDate->format('Y-m-d'),
            'end_date' => $endDate->format('Y-m-d'),
            'active' => 1,
        ];
    }
}
