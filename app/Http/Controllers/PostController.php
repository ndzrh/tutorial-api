<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use App\Http\Resources\PostResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Http\Resources\PostDetailResource;

class PostController extends Controller
{
    public function index()
    {
        $posts = Post::all();
        // return response()->json(['data' => $posts]); // convert to JSON to send data to the front-end
        return PostDetailResource::collection($posts->loadMissing('writer:id,username', 'comments:id,post_id,user_id,comments_content')); //collection-> untuk more than 1 data, dlm arrays
    }

    public function show($id)
    {
        //writer->nama function dlm relationship, refer to Post model file
        $posts = Post::with('writer:id,username')->findOrFail($id); //writer:id,username-> tak boleh ada SPACE between id & username
        // return response()->json(['data' => $posts]);
        return new PostDetailResource($posts->loadMissing('writer:id,username', 'comments:id,post_id,user_id,comments_content')); //untuk satu data shj, example->find by $id
    }

    //pakai eager loading
    public function show2($id)
    {
        //writer->nama function dlm relationship, refer to Post model file
        $posts = Post::findOrFail($id); //writer:id,username-> tak boleh ada SPACE between id & username
        // return response()->json(['data' => $posts]);
        return new PostDetailResource($posts); //untuk satu data shj, example->find by $id
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'title' => 'required|max:255', 
            'news_content' => 'required',
        ]);

        $image = null;

        if ($request->file) {

            $file_name = $this->generateRandomString();
            $extension = $request->file->extension();
            $image = $file_name.'.'.$extension;

            Storage::putFileAs('image', $request->file, $file_name.'.'.$extension);

        }

        $request['image'] = $image;
        $request['author'] = Auth::user()->id;
        $posts = Post::create($request->all());

        return new PostDetailResource($posts->loadMissing('writer:id,username')); //untuk satu data shj, example->find by $id
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required|max:255', 
            'news_content' => 'required',
        ]);

        $post = Post::findOrFail($id);
        $post->update($request->all());

        return new PostDetailResource($post->loadMissing('writer:id,username')); //untuk satu data shj, example->find by $id


    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();

        return new PostDetailResource($post->loadMissing('writer:id,username')); //untuk satu data shj, example->find by $id
    }

    function generateRandomString($length = 30) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomString;
    }

}
