<?php

namespace App\Repositories\Eloquent;

use App\Models\Models\Design;
use App\Repositories\Eloquent\BaseRepository;
use App\Repositories\Contracts\DesignInterface;

class DesignRepository extends BaseRepository implements DesignInterface
{
    public function model()
    {
        //returning the namespace of the model 'App\Models\Design'
        return Design::class;
    }

    public function applyTags($id, array $data){
        $design = $this->find($id);
        $design->retag($data);
    }

    public function addComment($designId, array $data){
        $design = $this->find($designId);
        $comment = $design->comments()->create($data);
        return $comment;
    }

    public function like($id)
    {
        $design = $this->model->findOrFail($id);
        if ($design->isLikedByUser(auth()->id())) {
            $design->unlike();
        }else{
            $design->like();
        }

    }

    public function isLikedByUser($id){
        $design = $this->model->findOrFail($id);
        return $design->isLikedByUser(auth()->id());
    }
}