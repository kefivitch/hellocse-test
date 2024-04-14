<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProfileCollection;
use App\Models\Profile;
use App\Http\Requests\StoreProfileRequest;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function index(Request $request)
    {
        $profiles = Profile::whereActive()->paginate();
        return new ProfileCollection($profiles);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProfileRequest $request)
    {
        // get Authenticated user id
        $userId = $request->user()->id;

        $validatedData = $request->validated();

        // Add user_id to validated data
        $validatedData['user_id'] = $userId;

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('profile_images', 'public');
            $validatedData['image'] = $imagePath;
        }

        // if no status is set, set default status
        $validatedData['status'] = $validatedData['status'] ?? 'inactif';

        $profile = Profile::create($validatedData);

        return response()->json(['message' => 'Profile created successfully', 'profile' => $profile], 201);
    }
}
