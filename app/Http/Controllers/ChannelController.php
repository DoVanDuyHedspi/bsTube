<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Channel;
use Alaouy\Youtube\Facades\Youtube;

class ChannelController extends Controller {

    public function index(Channel $channel) {
        return view('channels.index', compact('channel'));
    }

    public function getPlaylist(Request $request, Channel $channel) {
        $channel_name = $request->query('channel_name');
        $playlists = Channel::find($channel_name)->link;
        foreach($playlists as $stt => $videoId) {
            $playlists[$stt] = Youtube::getVideoInfo($videoId);
            $playlists[$stt]->contentDetails->duration = $channel->covtime($playlists[$stt]->contentDetails->duration);
        }
        return response()->json([
            'playlists' => $playlists,
        ]);
    }
}
