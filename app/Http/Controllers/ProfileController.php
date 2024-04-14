<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
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

    public function update(UpdateProfileRequest $request, Profile $profile)
    {
        $profile->update($request->validated());

        return response()->json(['message' => 'Profile updated successfully', 'profile' => $profile], 200);
    }

    public function destroy(Profile $profile)
    {
        $profile->delete();

        return response()->json(['message' => 'Profile deleted successfully'], 200);
    }
}
