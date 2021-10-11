<?php

namespace App\Repositories\Eloquent;


use App\Models\Models\Comment;
use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\Contracts\CommentInterface;

class CommentRepository extends BaseRepository implements CommentInterface
{
    public function model()
    {
        //returning the namespace of the model 'App\Models\Comment'
        return Comment::class;
    }
}