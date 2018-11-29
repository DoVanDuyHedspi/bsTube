@extends('layouts.app')

@section('content')
    <section id="mainpage">
      <div class="container">
        <div class="container">
          <h2 class="text-primary">{{ $channel->name }}</h2>
        </div>
      </div>
    </section>
    <div class="col-md-12">
        <input id="channel_name" type="hidden" value="{{$channel->name}}">
        <div id="root"></div>
    </div>

@endsection
