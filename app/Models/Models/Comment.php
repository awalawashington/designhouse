<?php

namespace App\Models\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'body',
        'user_id'
    ];

    public function commentable()
    {
        return $this->morphsTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
