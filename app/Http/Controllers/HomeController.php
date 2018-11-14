<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Alaouy\Youtube\Facades\Youtube;
use App\Channel;

class HomeController extends Controller {
    public function index(){
      $channels = Channel::all();
      return view('home', compact('channels'));
    }
}
