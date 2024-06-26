<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCommentRequest;
use App\Models\Comment;
use App\Models\Profile;

class CommentController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCommentRequest $request, Profile $profile)
    {
        $admin = $request->user();

        // Check if the admin is an administrator and has already posted a comment on this profile
        if ($admin && $profile->comments()->where('admin_id', $admin->id)->exists()) {
            return response()->json(['message' => 'Administrators can only post one comment on a profile.'], 403);
        }

        // Create the comment
        $comment = new Comment;
        $comment->content = $request->input('content');
        $comment->admin()->associate($admin);
        $comment->profile()->associate($profile);
        $comment->save();

        return response()->json(['message' => 'Comment added successfully', 'comment' => $comment], 201);
    }
}
