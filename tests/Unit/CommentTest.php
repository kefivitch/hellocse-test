<?php

namespace Tests\Unit;
use App\Models\Profile;
use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class CommentTest extends TestCase
{

    use RefreshDatabase;

    public function test_authenticated_admin_can_add_comment_to_profile()
    {
        $admin = Admin::factory()->create();
        $profile = Profile::factory()->create();

        $this->actingAs($admin);

        $response = $this->postJson("/api/v1/profiles/{$profile->id}/comments", [
            'content' => 'This is a test comment.',
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('comments', ['content' => 'This is a test comment.']);
    }

    public function test_administrator_can_only_post_one_comment_on_profile()
    {
        $admin = Admin::factory()->create();
        $profile = Profile::factory()->create();

        $this->actingAs($admin);

        // Post the first comment
        $response1 = $this->postJson("/api/v1/profiles/{$profile->id}/comments", [
            'content' => 'First comment.',
        ]);

        $response1->assertStatus(201);

        // Attempt to post the second comment
        $response2 = $this->postJson("/api/v1/profiles/{$profile->id}/comments", [
            'content' => 'Second comment.',
        ]);

        $response2->assertStatus(403);
        $this->assertDatabaseCount('comments', 1);
    }
}
