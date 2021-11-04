<?php

namespace App\Repositories\Eloquent;

use App\Models\Models\Message;
use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\Contracts\MessageInterface;

class MessageRepository extends BaseRepository implements MessageInterface
{
    public function model()
    {
        //returning the namespace of the model 'App\Models\Message'
        return Message::class;
    }

}