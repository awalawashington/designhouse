<?php

namespace App\Models\Models;

use App\Models\User;
use App\Models\Models\Design;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'owner_id',
        'name',
        'slug',
       
    ];

    protected static function boot()
    {
        parent::boot();

        //when team is created, add current user as a team member
        static::created(function($team){
            //auth()->user()->teams()->attach($team->id);
            $team->members()->attach(auth()->id());
        });

        //when team is deleted, delete team members too
        static::deleting(function($team){
            $team->members()->sync([]);
        });
    }

    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function members()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }

    public function designs()
    {
        return $this->hasMany(Design::class);
    }

    public function hasUser(User $user)
    {
        return $this->members()->where('user_id', $user->id)->first() ? true : false;
    }

    public function invitations()
    {
        return $this->hasMany(Invitation::class);
    }

    public function hasPendingInvite($email)
    {
        return (bool) $this->invitations()->where('recipient_email', $email)->count();
    }
}
