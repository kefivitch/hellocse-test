<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProfileRequest;
use App\Http\Requests\UpdateProfileRequest;
use App\Http\Resources\ProfileCollection;
use App\Models\Profile;
use App\Repositories\ProfileRepository;
use Illuminate\Http\Request;

class ProfileController extends Controller
{
    public function __construct(private ProfileRepository $profileRepository)
    {
    }

    public function index(Request $request)
    {
        return new ProfileCollection(
            $this->profileRepository->getActiveProfiles(
                perPage: $request->has('perPage') ? $request->perPage : 10
            )
        );
    }

    public function store(StoreProfileRequest $request)
    {
        // get Authenticated admin id
        $adminId = $request->user()->id;

        $validatedData = $request->validated();

        // Add admin_id to validated data
        $validatedData['admin_id'] = $adminId;

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
        $validatedData = $request->validated();

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('profile_images', 'public');
            $validatedData['image'] = $imagePath;
        }

        $profile->update($validatedData);

        return response()->json(['message' => 'Profile updated successfully', 'profile' => $profile], 200);
    }

    public function destroy(Profile $profile)
    {
        $profile->delete();

        return response()->json(['message' => 'Profile deleted successfully'], 200);
    }
}
