<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Channel;

class ChannelController extends Controller {

    public function index(Channel $channel) {
        return view('channels.index', compact('channel'));
    }

    public function getPlaylist(Request $request) {
        $channel_name = $request->query('channel_name');
        $playlist = Channel::find($channel_name)->link;
        return response()->json([
            'playlist' => $playlist,
        ]);
    }
}
