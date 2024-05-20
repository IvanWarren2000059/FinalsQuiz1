<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Comment;
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
}
