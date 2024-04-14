<?php

namespace App\Builders;
use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Builder;

class ProfileBuilder extends Builder
{
    /*
     * @return Builder $this
     *
     * custom eloquent query builder to filter profiles by active status
    */
    public function whereActive()
    {
        return $this->where('status', StatusEnum::Actif->value);
    }
}
