<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $comments = Comment::query();
        return $comments->paginate();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function storeReply(CommentRequest $request, Comment $parent)
    {
        $params = $request->validated();
        $comment = Comment::create([
            'user_id' => Auth::id(),
            'announcement_id' => $parent->announcement->id,
            'parent_id' => $parent->id,
            'content' => $params['content'],
        ]);
        return $comment;
    }

    /**
     * Display the specified resource.
     */
    public function show(Comment $comment)
    {
        $comment->load('user', 'replies');
        return $comment;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CommentRequest $request, Comment $comment)
    {
        $params = $request->validated();
        $comment->update($params);
        return $comment;
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Comment $comment)
    {
        $comment->delete();
        return response()->json(['message' => 'Comment deleted successfully']);
    }
}
