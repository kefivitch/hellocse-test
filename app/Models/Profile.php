<?php

namespace App\Models;

use App\Builders\ProfileBuilder;
use App\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    use HasFactory;

    protected $fillable = [
        "name",
        "first_name",
        "image",
        "status",
        "user_id",
    ];

    protected $casts = [
        'status' => StatusEnum::class,
    ];


    public function newEloquentBuilder($query): ProfileBuilder
    {
        return new ProfileBuilder($query);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
