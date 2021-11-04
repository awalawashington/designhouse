<?php

namespace App\Models\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Invitation extends Model
{
    use HasFactory;

    protected $fillable = [
        'recipient_email',
        'sender_id',
        'team_id',
        'token'      
    ];

    public function team()
    {
        return $this->belongsTo(Team::class);
    }

    public function recipient()
    {
        return $this->hasOne(User::class, 'email', 'recipient_email');
    }

    public function sender()
    {
        return $this->hasOne(User::class, 'id', 'sender_id');
    }
}
