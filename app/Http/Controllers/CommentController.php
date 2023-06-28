<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\Comment\CreateCommentRequest;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json([
            'data' => Comment::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CreateCommentRequest $request)
    {
        $cleanRequest = $this->_cleanRequest($request->validated());
        $comment = new Comment();
        $comment->movie_slug = Str::slug($cleanRequest['movie_slug'], '_');
        $comment->comment = $cleanRequest['comment'];
        $comment->ip_address = $cleanRequest['ip_address'] ?? $request->ip();
        $comment->save();

        // so that the movies will be updated immediately
        Cache::pull('movies_cache');
        
        return response()->json([
            'message' => 'Added Comment',
            'comment' => $comment
        ], 201);
    }

    /**
     * Format the request for internal use
     */
    private function _cleanRequest($data)
    {
        return [
            'movie_slug' => $data['movieTitle'],
            'comment' => $data['comment'],
            'ip_address' => $data['ip'],
        ];
    }
}
