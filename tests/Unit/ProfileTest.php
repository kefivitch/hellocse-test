<?php

namespace Tests\Unit;

use App\Enums\StatusEnum;
use App\Models\Admin;
use App\Models\Profile;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function store_method_creates_profile()
    {
        $admin = Admin::factory()->create();
        $this->actingAs($admin);

        Storage::fake('public');

        $file = UploadedFile::fake()->image('test_image.jpg');

        // Dummy profile data
        $profileData = [
            'name' => 'John Doe',
            'first_name' => 'John',
            'image' => $file,
            'status' => Arr::random(StatusEnum::cases()),
        ];

        $response = $this->postJson(route('api.v1.profiles.store'), $profileData);

        // Assert that the profile was created
        $response->assertStatus(201);
        $response->assertJson(['profile' => ['image' => 'profile_images/' . $file->hashName()]]);
        Storage::disk('public')->assertExists('profile_images/' . $file->hashName());
    }

    /**
     * @test
     */
    public function profiles_endpoint_returns_profiles()
    {
        // Create profiles
        Profile::factory()->count(3)->create(['status' => StatusEnum::Actif]);
        Profile::factory()->count(1)->create(['status' => StatusEnum::Inactif]);
        Profile::factory()->count(1)->create(['status' => StatusEnum::Pending]);

        $response = $this->get(route('api.v1.profiles.index'));
        $response->assertStatus(200);

        $response->assertJsonStructure([
            'data' => [
                '*' => ['id', 'name', 'first_name', 'image'],
            ],
        ]);

        // Assert response data
        $response->assertJsonCount(3, 'data');
    }

    /**
     * @test
     */
    public function profiles_endpoint_includes_status_for_authenticated_admin()
    {
        // Authenticate an admin
        $admin = Admin::factory()->create();
        $this->actingAs($admin, 'sanctum');

        $profile = Profile::factory()->create(['status' => StatusEnum::Actif]);

        $response = $this->get(route('api.v1.profiles.index'));

        // Assert response includes status field
        $response->assertJsonFragment(['status' => $profile->status]);
    }

    /**
     * @test
     */
    public function profiles_endpoint_excludes_status_for_guest()
    {
        Profile::factory()->create(['status' => StatusEnum::Actif]);

        $response = $this->get(route('api.v1.profiles.index'));

        // Assert response excludes status field
        $response->assertJsonMissing(['status']);
    }

    /**
     * @test
     */
    public function update_profile()
    {
        // Create an authenticated admin
        $admin = Admin::factory()->create();
        $this->actingAs($admin);

        $profile = Profile::factory()->create();

        Storage::fake('public');

        $file = UploadedFile::fake()->image('updated_test_image.jpg');

        // New data to update profile
        $newData = [
            'name' => 'Updated Name',
            'first_name' => 'Updated First Name',
            'image' => $file,
        ];

        $response = $this->put(route('api.v1.profiles.update', $profile), $newData);

        $response->assertStatus(200);

        // Refresh profile from database
        $profile->refresh();

        // Assert profile is updated with new data
        $this->assertEquals($newData['name'], $profile->name);
        $this->assertEquals($newData['first_name'], $profile->first_name);
        $response->assertJson(['profile' => ['image' => 'profile_images/' . $file->hashName()]]);
        Storage::disk('public')->assertExists('profile_images/' . $file->hashName());
    }

    /**
     * @test
     */
    public function delete_profile()
    {
        $admin = Admin::factory()->create();
        $this->actingAs($admin);

        $profile = Profile::factory()->create();

        $response = $this->deleteJson(route('api.v1.profiles.destroy', $profile));

        $response->assertStatus(200);

        // Assert profile is deleted from database
        $this->assertDatabaseMissing('profiles', ['id' => $profile->id]);
    }
}
