<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Channel;

class ChannelController extends Controller {

    public function index(Channel $channel) {
        return view('channels.index', compact('channel'));
    }
}
