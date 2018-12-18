<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Channel;
use Alaouy\Youtube\Facades\Youtube;
use Illuminate\Support\Facades\Auth;
use App\Events\ChangePermissions;
use App\Events\NextVideo;
use App\Events\AddLink;
use App\Events\PlayNewVideo;
use App\Events\QueueNext;
use App\Events\DeleteVideo;
use App\Events\VoteNext;
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
        $channel->vote_next = 0;
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

    public function addLink(Request $request, Channel $channel) {
        $channel = Channel::find($request->channel_name);
        $newLink = $channel->getYoutubeIdFromUrl($request->newLink);
        // $newLink = $request->newLink;
        $playlists = $channel->link;
        if(count($playlists) == 0 ) {
            $channel->start_video_time = new DateTime();
        }
        if($request->type == "atEnd"){
            $addLink = array_push($playlists, $newLink);
        } else {
            $addLink = array_splice( $playlists, 1, 0, $newLink );
        }
        $channel->link = $playlists;
        
        $channel->save();
        foreach($playlists as $stt => $videoId) {
            $youtube = Youtube::getVideoInfo($videoId);
            // dd($youtube);
            $playlists[$stt] = array(
                "id" => $videoId,
                "snippet" => [
                    "title" => $youtube->snippet->title
                ],
                "contentDetails" => [
                    "duration" => $channel->covtime($youtube->contentDetails->duration)
                ]
            );
        }
        broadcast(new AddLink($channel, $playlists))->toOthers();
        return response()->json([
            'newPlaylists' => $playlists
        ]);
    }

    public function voteNext (Request $request) {
        $channel = Channel::find($request->channel_name);
        $channel->vote_next++;
        $vote_next = $channel->vote_next;
        $channel->save();

        broadcast(new VoteNext($channel, $vote_next));
        return response()->json([
            'voteNext' => $vote_next
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

    public function playNewVideo(Request $request) {
        $id = $request->id;
        $channel = Channel::find($request->channel_name);
        $playlists = $channel->link;
        $playlists[0]=$playlists[$id];
        unset($playlists[$id]);
        $channel->link = $playlists;
        $channel->start_video_time = new DateTime('NOW');
        $channel->save();
        broadcast(new PlayNewVideo($id,$channel))->toOthers();

    }

    public function queueNext(Request $request) {
        $index = $request->id;
        $channel = Channel::find($request->channel_name);
        $playlists = $channel->link;
        $video = $playlists[$index];
        for($i=$index; $i>1 ; $i--) {
            $playlists[$i] = $playlists[$i-1];
        }
        $playlists[1] = $video;
        $channel->link = $playlists;
        broadcast(new QueueNext($index,$channel))->toOthers();
    }

    public function deleteVideo(Request $request) {
        $index = $request->id;
        $channel = Channel::find($request->channel_name);
        $playlists = $channel->link;
        unset($playlists[$index]);
        $channel->link = $playlists;
        $channel->save();
        broadcast(new DeleteVideo($index, $channel));
    }
}
