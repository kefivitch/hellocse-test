<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        "content",
        "admin_id",
        "profile_id",
    ];

    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }

    public function profile()
    {
        return $this->belongsTo(Profile::class);
    }
}
