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
        'name',
        'first_name',
        'image',
        'status',
        'admin_id',
    ];

    protected $casts = [
        'status' => StatusEnum::class,
    ];

    public function newEloquentBuilder($query): ProfileBuilder
    {
        return new ProfileBuilder($query);
    }

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
