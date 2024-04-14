<?php

namespace Database\Factories;

use App\Models\Admin;
use App\Models\Profile;
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
                return Admin::factory()->create()->id;
            },
            'profile_id' => function () {
                return Profile::factory()->create()->id;
            },
        ];
    }
}
