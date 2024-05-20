<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
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
}
