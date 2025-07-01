<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Post $post)
    {
        $request->validate([
            'comment_body' => 'required|string',
        ]);

        $comment = new Comment([
            'comment_body' => $request->input('comment_body'),
        ]);
        $comment->user()->associate($request->user());
        $post->comments()->save($comment);

        return back()->with('success', 'Comment added!');
    }
}
