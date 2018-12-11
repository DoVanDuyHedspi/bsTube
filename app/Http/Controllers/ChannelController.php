<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Channel;
use Alaouy\Youtube\Facades\Youtube;
use Illuminate\Support\Facades\Auth;
use App\Events\ChangePermissions;

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

    public function getStatus(Request $request, Channel $channel) {
        $channel_name = $request->query('channel_name');
        $channel = Channel::find($channel_name);
        if(Auth::user()->id == $channel->channel_master_id) {
            return response()->json([
                'status' => $channel->status,
                'isMaster' => true
            ]);
        } else {
            return response()->json([
                'status' => $channel->status,
                'isMaster' => false
            ]);
        }
    }

    public function changePermissions(Request $request) {
        $channel = Channel::find($request->channel_name);
        if($request->status == 1) {
            $channel->status = 2;
        } else {
            $channel->status = 1;
        }
        $channel->save();
        broadcast(new ChangePermissions($channel->status, $channel))->toOthers();
        return response()->json([
            'status' => $channel->status
        ]);
    }
}
