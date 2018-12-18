@extends('layouts.app')

@section('content')
    {{--<section id="mainpage">--}}
      {{--<div class="container">--}}
        <div class="container" style="margin-left: 20px">
          <h2 class="text-primary">CHANNEL : {{ $channel->name }}</h2>
        </div>
      {{--</div>--}}
    {{--</section>--}}
    <div class="col-md-12 row">
        <input id="channel_name" type="hidden" value="{{$channel->name}}">
        <div id="comment" class="col-md-5"></div>
        <div id="youtube" class="col-md-7"></div>
    </div>

@endsection
