<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Channel;
use Alaouy\Youtube\Facades\Youtube;
use Illuminate\Support\Facades\Auth;
use App\Events\ChangePermissions;
use App\Events\NextVideo;
use DateTime;

class ChannelController extends Controller {

    public function index(Channel $channel) {
        return view('channels.index', compact('channel'));
    }

    public function updateNumbersOfMembers(Request $request) {
        $channel = Channel::find($request->channel_name);
        $channel->numbers_of_member = $request->numbersOfMembers;
        $channel->save();

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

    public function removeFirstVideo(Request $request) {
        $channel = Channel::find($request->channel_name);
        $playlists = $channel->link;
        $videoIdRemoved = array_shift($playlists);
        $channel->link = $playlists;
        $channel->start_video_time = new DateTime();
        // dd($channel->start_video_time);
        $channel->save();
        foreach($playlists as $stt => $videoId) {
            $playlists[$stt] = Youtube::getVideoInfo($videoId);
            $playlists[$stt]->contentDetails->duration = $channel->covtime($playlists[$stt]->contentDetails->duration);
        }
        broadcast(new NextVideo($channel))->toOthers();
        return response()->json([
            'newPlaylists' => $playlists
        ]);
    }

    public function getStartVideoTime(Request $request) {
        $channel_name = $request->query('channel_name');
        $channel = Channel::find($channel_name);
        $start_video_time = $channel->start_video_time;
        date_default_timezone_set('Europe/Lisbon');
        $date = new DateTime( 'NOW' );
        $date2 = new DateTime($start_video_time);
        $diffSeconds = $date->getTimestamp() - $date2->getTimestamp();
        return response()->json([
            'datetime' => $diffSeconds
        ]);
    }
}
