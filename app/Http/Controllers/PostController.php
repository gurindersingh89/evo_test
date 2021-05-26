<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    private $message = 'Post Saved Successfully';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::simplePaginate(10);
        return view('posts.posts', compact('posts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, Post $post)
    {
        $rules = [
            'name' => ['required']
        ];
        $validate_attributes = $request->validate($rules);

        $post->fill($validate_attributes);
        $post->save();
        // Post::create(['name' => $request->name]);

        return array('type' => 'success','message' => $this->message, 'data' => $post);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return array('type' => 'success', 'data' => $post);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $this->message = 'Post Updated Successfully';
        return $this->store($request, $post);
        
        // $post->fill($request->all());
        // $post->name = $request->name;
        // $post->update();
        // return array('type' => 'success', 'message' => 'Post Updated Successfully', 'data' => $post);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        $post->delete();
        return response()->json([], 204);
    }
}
