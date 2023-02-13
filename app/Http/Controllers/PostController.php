<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
use App\Http\Resources\PostDetailResource;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        // return response()->json(['data' => $posts]); // convert to JSON to send data to the front-end
        return PostResource::collection($posts); //collection-> untuk more than 1 data, dlm arrays
    }

    public function show($id)
    {
        //writer->nama function dlm relationship, refer to Post model file
        $posts = Post::with('writer:id,username')->findOrFail($id); //writer:id,username-> tak boleh ada SPACE between id & username
        // return response()->json(['data' => $posts]);
        return new PostDetailResource($posts); //untuk satu data shj, example->find by $id
    }

    //pakai eager loading
    public function show2($id)
    {
        //writer->nama function dlm relationship, refer to Post model file
        $posts = Post::findOrFail($id); //writer:id,username-> tak boleh ada SPACE between id & username
        // return response()->json(['data' => $posts]);
        return new PostDetailResource($posts); //untuk satu data shj, example->find by $id
    }
}
