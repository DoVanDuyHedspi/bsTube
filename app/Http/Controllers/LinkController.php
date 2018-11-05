<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Link;
use App\Events\AddLinkYoutube;

class LinkController extends Controller
{
    public function create(Request $request) {
        $new_link = new Link;
        $new_link->link_id = $request->link_id;
        $new_link->save();
        broadcast(new AddLinkYoutube($new_link))->toOthers();
    }
}
