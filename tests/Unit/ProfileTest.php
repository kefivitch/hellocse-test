<?php

namespace Tests\Unit;

use App\Enums\StatusEnum;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Arr;
use Illuminate\Http\UploadedFile;


class ProfileTest extends TestCase
{
    use RefreshDatabase;

    public function test_store_method_creates_profile()
    {
        // Create a dummy authenticated user
        $user = User::factory()->create();

        // Mock authentication
        $this->actingAs($user);

        Storage::fake('public');

        $file = UploadedFile::fake()->image('test_image.jpg');

        // Dummy profile data
        $profileData = [
            'name' => 'John Doe',
            'first_name' => 'John',
            'image' => $file,
            'status' => Arr::random(StatusEnum::cases()),
        ];

        // Send POST request to store endpoint with dummy data
        $response = $this->postJson('/api/v1/profiles', $profileData);

        // Assert that the profile was created
        $response->assertStatus(201);
        $response->assertJson(['profile' => ['image' => 'profile_images/' . $file->hashName()]]);
        Storage::disk('public')->assertExists('profile_images/' . $file->hashName());

    }
}
