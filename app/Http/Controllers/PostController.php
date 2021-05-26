<?php

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
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
    public function store(PostRequest $request, Post $post)
    {
        // $rules = [
        //     'name' => ['required']
        // ];
        // $validate_attributes = $request->validate($rules);

        // 1
        // Post::create(['name' => $request->name]);

        // 2
        // $post->fill($validate_attributes);
        // $post->save();

        // 3
        $post->fill($request->validated());
        $post->save();

        return array('type' => 'success', 'message' => $this->message, 'data' => $post);
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
    public function update(PostRequest $request, Post $post)
    {
        // 1   
        // $post->fill($request->all());
        // $post->name = $request->name;
        // $post->update();
        // return array('type' => 'success', 'message' => 'Post Updated Successfully', 'data' => $post);

        // 2
        $this->message = 'Post Updated Successfully';
        return $this->store($request, $post);
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
