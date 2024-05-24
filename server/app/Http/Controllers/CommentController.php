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

    public function update(Request $request, $id)
    {
        $request->validate([
            'comment' => 'required|string',
        ]);

        $comment = Comment::findOrFail($id);

        // Check if the authenticated user is the owner of the comment
        if ($comment->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $comment->comment = $request->comment;
        $comment->save();

        return response()->json(['message' => 'Comment updated successfully', 'comment' => $comment], 200);
    }

    public function delete($id)
    {
        $comment = Comment::findOrFail($id);

        // Check if the authenticated user is the owner of the comment
        if ($comment->user_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        $comment->delete();

        return response()->json(['message' => 'Comment deleted successfully'], 200);
    }
}
