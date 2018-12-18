<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Chat;
use App\Events\CommentCreated;

class ChatController extends Controller
{
    public function index(Request $request, Chat $chat) {
        $channel_name = $request->query('channel_name');
        $comments = $chat->Where('channel_name', $channel_name)->with('user')->get();
        return response()->json([
            'comments' => $comments,
        ]);
    }

    public function create(Request $request, Chat $comment) {
        $createdComment = $request->user()->chats()->create([
            'content' => $request->content,
            'channel_name' => $request->channel_name
        ]);

        broadcast(new CommentCreated($createdComment, $request->user()))->toOthers();

        return response()->json($comment->with('user')->find($createdComment->id));

    }
}
