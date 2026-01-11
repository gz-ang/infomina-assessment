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
        // Randomise plan
        $membership_plan_id = fake()->numberBetween(1, 5);

        // Generate membership start & end date
        $start_date = Carbon::parse(fake()->date());
        $end_date = $start_date->copy();
        switch ($membership_plan_id) {
            case 1:
                $end_date->addDays(7);
                break;
            case 2:
                $end_date->addMonths(1);
                break;
            case 3:
                $end_date->addMonths(3);
                break;
            case 4:
                $end_date->addYears(1);
                break;
            default:
                $end_date->addMonths(1);
                break;
        }
        
        return [
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'date_of_birth' => fake()->date(),
            'height' => fake()->numberBetween(140, 210),
            'weight' => fake()->randomFloat(1, 40, 120),
            'membership_plan_id' => $membership_plan_id,
            'start_date' => $start_date->format('Y-m-d'),
            'end_date' => $end_date->format('Y-m-d'),
            'active' => 1,
        ];
    }
}
