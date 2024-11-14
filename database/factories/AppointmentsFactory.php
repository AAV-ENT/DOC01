<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Clients;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Appointments>
 */
class AppointmentsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $userType = $this->faker->randomElement(['Client', 'Staff']);
        $createdBy = $userType == 'Client' ? Clients::factory() : 1;

        $confirmed = $this->faker->randomElement(['Yes', 'No']);
        $confirmation_type = $confirmed == 'Yes' ? $this->faker->randomElement(['SMS/Email', 'Phone call']) : NULL;

        return [
            'user_id' => 1,
            'user_type' => $userType,
            'created_by' => $createdBy,
            'service_id' => $this->faker->numberBetween(1, 3),
            'doctor_id' => $this->faker->numberBetween(1, 2),
            'confirmed' => $confirmed,
            'confirmation_type' => $confirmation_type,
            'date' => $this->faker->dateTimeThisYear(),
            'hour' => $this->faker->numberBetween(9, 21),
            'minute' => $this->faker->randomElement([00, 15, 30, 45])
        ];
    }
}
