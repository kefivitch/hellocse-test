<?php

namespace Tests\Unit;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;


class CommentTest extends TestCase
{

    use RefreshDatabase;

    public function test_authenticated_user_can_add_comment_to_profile()
    {
        $user = User::factory()->create();
        $profile = Profile::factory()->create();

        $this->actingAs($user);

        $response = $this->postJson("/api/v1/profiles/{$profile->id}/comments", [
            'content' => 'This is a test comment.',
        ]);

        $response->assertStatus(201);
        $this->assertDatabaseHas('comments', ['content' => 'This is a test comment.']);
    }

    public function test_administrator_can_only_post_one_comment_on_profile()
    {
        $user = User::factory()->create();
        $profile = Profile::factory()->create();

        $this->actingAs($user);

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
