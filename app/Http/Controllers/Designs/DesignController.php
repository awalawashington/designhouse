<?php

namespace App\Http\Controllers\Designs;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\Models\Design;
use App\Http\Controllers\Controller;
use App\Http\Resources\DesignResource;
use Illuminate\Support\Facades\Storage;
use App\Repositories\Eloquent\Criteria\IsLive;
use App\Repositories\Contracts\DesignInterface;
use App\Repositories\Eloquent\Criteria\ForUser;
use App\Repositories\Eloquent\Criteria\EagerLoad;
use App\Repositories\Eloquent\Criteria\LatestFirst;

class DesignController extends Controller
{

    protected $designs;

    public function __construct(DesignInterface $designs)
    {
        $this->designs = $designs;
    }

    public function index()
    {
        $designs = $this->designs->withCriteria([
            new LatestFirst(),
            new IsLive(),
            new ForUser(1),
            new EagerLoad(['user', 'comments'])
        ])->all();
        return DesignResource::collection($designs);
    }

    public function findDesign($id)
    {
        $design = $this->designs->find($id);
        return new DesignResource($design);
    }

    public function update(Request $request, $id)
    {
        $design = $this->designs->find($id);
        $this->authorize('update', $design);

        $this->validate($request,[
            'title' => ['required', 'unique:designs,title,'.$id],
            'description' => ['string', 'required', 'min:20', 'max:140'],
            'tags' => ['required']
        ]);

        
        //is live????
        $this->designs->update($id, [
            'title' => $request->title,
            'description' => $request->description,
            'slug' => Str::slug($request->title),
            'is_live' => !$design->upload_successful ? false : $request->is_live
        ]);

        //apply the tags
        $this->designs->applyTags($id, $request->tags);

        return new DesignResource($design);
    }

    public function destroy(Request $request, $id)
    {
        $design = $this->designs->find($id);

        $this->authorize('delete', $design);

        

        //delete files asssociated to the record
        
        foreach (['thumbnail', 'large', 'original'] as $size) {
            //check if file exists in the database
            if (Storage::disk($design->disk)->exists("uploads/designs/{$size}/".$design->image)) {
                Storage::disk($design->disk)->delete("uploads/designs/{$size}/".$design->image);
            }
        }

        $this->designs->delete($id);

        return response()->json(['message' => 'Record deleted'], 200);

    }

    public function like($id)
    {
        $this->designs->like($id);
        return response()->json(['message' => 'successful']);
    }

    public function checkIfUserHasLiked($designId)
    {
        $isLiked = $this->designs->isLikedByUser($designId);

        return response()->json(['liked' => $isLiked], 200);
    }
}
