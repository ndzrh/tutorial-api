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

        return CommentResource::collection($comments->loadMissing(['commentator'])); //collection-> untuk more than 1 data, dlm arrays
    }
}
