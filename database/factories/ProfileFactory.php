<?php

namespace Database\Factories;

use App\Enums\StatusEnum;
use App\Models\Admin;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Profile>
 */
class ProfileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name,
            'first_name' => $this->faker->firstName,
            'image' => $this->faker->imageUrl(),
            'status' => $this->faker->randomElement(StatusEnum::cases()),
            'admin_id' => function () {
                return Admin::factory()->create()->id;
            },
        ];
    }
}
