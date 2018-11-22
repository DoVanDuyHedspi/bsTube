<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Channel;

class MyChannelsController extends Controller
{
    public function index(){
        $my_channels = Auth::user()->channels;
        return view('my_channels.index', compact('my_channels'));
    }

    public function store(Request $request) {
        $validatedData = $request->validate([
            'name' => 'required|unique:channels|max:100|alpha_num'
        ]);
        $newChannel = $request->user()->channels()->create(
            [
                'name' => $request->name,
                'numbers_of_member' => 0,
                'link' => [],
                'vote_next' => 1
            ]
        );
        return redirect()->back()->with('message', 'Success!');
    }

    public function destroy($name) {
        $channel = Channel::find($name);
        $channel->delete();

        return redirect()->back();
    }
}
