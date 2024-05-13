<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    // public function index()
    // {
    //     return view('posts.index', ['posts' => Post::all()]);
    // }

    // public function store(Request $request){
    //     //create an instance of the Post model and save the data
    //     $post = new Post();
    //     $post->title = $request->title;
    //     $post->body = $request->body;
    //     $post->user_id = rand(4, 14);
    //     $post->save();
    //     return redirect('/posts');
    // }

    // public function show($id){
    //     // the firstOrFail() method will throw an exception if the post is not found
    //     $post = Post::with('user')->where('id', $id)->firstorFail();
    //     return view('posts.show', ['post' => $post]);
    // }

    // public function edit($id){
    //     // the firstOrFail() method will throw an exception if the post is not found
    //     $post = Post::where('id', $id)->firstOrFail();
    //     return view('posts.edit', ['post' => $post]);
    // }

    // public function update(Request $request, $id){
    //     // the firstOrFail() method will throw an exception if the post is not found
    //     $post = Post::where('id', $id)->firstOrFail();
    //     $post->title = $request->title;
    //     $post->body = $request->body;
    //     $post->save();
    //     return redirect('/posts');
    // }

    // public function destroy($id){
    //     // the firstOrFail() method will throw an exception if the post is not found
    //     $post = Post::where('id', $id)->firstOrFail();
    //     $post->delete();
    //     return redirect('/posts');
    // }


    public function index()
    {
        return response()->json(['posts' => Post::all()]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);
    
        $post = new Post();
        $post->title = $request->title;
        $post->body = $request->body;
        $post->user_id = $request->user_id; // Corrected
        $post->save();
    
        return response()->json(['message' => 'Post created successfully', 'post' => $post], 201);
    }
    

    
    public function show($id)
    {
        $post = Post::with('user')->findOrFail($id);
        return response()->json(['post' => $post]);
    }

    public function edit($id)
    {
        $post = Post::findOrFail($id);
        return response()->json(['post' => $post]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required',
            'body' => 'required',
        ]);

        $post = Post::findOrFail($id);
        $post->title = $request->title;
        $post->body = $request->body;
        $post->save();

        return response()->json(['message' => 'Post updated successfully', 'post' => $post]);
    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        return response()->json(['message' => 'Post deleted successfully']);
    }


    public function isAuthor(Request $request, $id)
    {
        // Find the post
        $post = Post::findOrFail($id);

        // Get the authenticated user
        $user = Auth::user();

        // Check if the user is an admin
        if ($user->user_Type === 'Admin') {
            return response()->json(['message' => 'User is an admin'], 200);
        }

        // Check if the user is the author of the post
        if ($user->id === $post->user_id) {
            return response()->json(['message' => 'User is the author of the post'], 200);
        } else {
            return response()->json(['message' => 'User is not authorized to edit/delete this post'], 403);
        }
    }


}
