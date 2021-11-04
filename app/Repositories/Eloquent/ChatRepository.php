<?php

namespace App\Repositories\Eloquent;

use App\Models\Models\Chat;
use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\Contracts\ChatInterface;

class ChatRepository extends BaseRepository implements ChatInterface
{
    public function model()
    {
        //returning the namespace of the model 'App\Models\Chat'
        return Chat::class;
    }

    public function createParticipants($chatId, array $data){
        $chat = $this->model->find($chatId);
        $chat->participants()->sync($data);
    }

    public function getUserChats(){
        return auth()->user()->chats()->with(['messages', 'participants'])->get();
    }

}