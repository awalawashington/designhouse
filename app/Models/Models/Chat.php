<?php

namespace App\Models\Models;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Chat extends Model
{
    use HasFactory;

    public function participants()
    {
        return $this->belongsToMany(User::class, 'participants');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    //helpers

    public function getLatestMessageAttribute()
    {
        return $this->messages()->latest()->first();
    }

    public function isUnreadForUser($userId)
    {
        return(bool)$this->messages()->whereNull('last_read')->where('user_id', '<>', $userId)->count();
    }

    public function markAsReadForUser($userId)
    {
        $this->messages()->whereNull('last_read')->where('user_id', '<>', $userId)->update(['last_read' => Carbon::now()]);
    }



}
