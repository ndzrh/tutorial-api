<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Resources\CommentResource;

class CommentController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'post_id' => 'required|exists:posts,id', 
            'comments_content' => 'required',
        ]);

        //GET USER, siapa yang comment
        $request['user_id'] = auth()->user()->id;

        $comments = Comment::create($request->all());

        // return response()->json($comments->loadMissing(['commentator']));
        return new CommentResource($comments->loadMissing(['commentator:id,username']));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([ 
            'comments_content' => 'required',
        ]);

        $comments = Comment::findOrFail($id);
        $comments->update($request->only('comments_content'));

        return new CommentResource($comments->loadMissing(['commentator:id,username']));
    }

    public function destroy($id)
    {
        $comments = Comment::findOrFail($id);
        $comments->delete();

        return new CommentResource($comments->loadMissing(['commentator:id,username']));
    }
}
