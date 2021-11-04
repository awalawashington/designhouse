<?php

namespace App\Models\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Message extends Model
{
    use HasFactory, SoftDeletes;

    protected $touches = ['chat'];

    protected $fillable = [
        'chat_id',
        'user_id',
        'body',
        'last_read'
    ];

    public function getBodyAttribute($value)
    {
        if ($this->trashed()) {
            if (! auth()->check()) return null;
            
            return auth()->id()  == $this->sender->id ? 'You deleted this message' : '{$this->sender->name} deleted this message';
        }

        return $value;
    }

    public function chat()
    {
        return $this->belongsTo(Chat::class);
    }

    public function sender()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
