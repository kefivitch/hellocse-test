<?php

namespace App\Repositories;

use App\Models\Profile;

class ProfileRepository
{
    /**
     * Create a new class instance.
     */
    public function __construct(private Profile $model)
    {
    }

    public function getActiveProfiles(bool $paginated = true, int $perPage = 10)
    {
        return $paginated ?
            $this->model->whereActive()->paginate($perPage) :
            $this->model->whereActive()->get();
    }
}
