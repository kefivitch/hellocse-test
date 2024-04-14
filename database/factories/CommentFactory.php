<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'content' => $this->faker->paragraph,
            'admin_id' => function () {
                return \App\Models\Admin::factory()->create()->id;
            },
            'profile_id' => function () {
                return \App\Models\Profile::factory()->create()->id;
            },
        ];
    }
}
