<?php

namespace App\Models;

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


    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
