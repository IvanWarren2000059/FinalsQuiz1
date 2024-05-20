<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
<<<<<<< HEAD
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{

public function create(Request $request)
{
    $request->validate([
        'post_id' => 'required|exists:posts,id',
        'comment' => 'required|string',
    ]);

    $comment = new Comment();
    $comment->user_id =$request->user_id;
    $comment->post_id = $request->post_id;
    $comment->comment = $request->comment;
    $comment->save();

    return response()->json(['message' => 'Comment created successfully', 'comment' => $comment], 201);
}

public function showComments($postId)
{
    $comments = Comment::where('post_id', $postId)
        ->with('user:id,name') 
        ->get();
    return response()->json($comments);
}
=======
use Exception;

class CommentController extends Controller
{
    public function store(Request $request)
    {


        try {

            $response = Comment::create([
                'post_id' => $request->post_id,
                'comment' => $request->comment_body,
                'user_id' => $request->user()->id
            ]);

            // Eager load the user relationship
            $response->load('user');

            return response([
                "status" => "Success",
                "response" => $response
            ]);


        } catch (Exception $e) {
            return response(['message' => $e->getMessage()], 500);

        }


    }
>>>>>>> b22ed6f2b4912c22d2366baeb81eb9dfd8f34101
}
