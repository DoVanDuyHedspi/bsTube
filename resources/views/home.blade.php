@extends('layouts.auth')

@section('content')
    <section id="mainpage">
      <div class="container">
          <div class="col-lg-3 col-md-3">
              <h3>Enter Channel</h3>
              <input class="form-control" style="background-color: rgb(26, 26, 26); color: white" id="channelname" type="text" placeholder="Channel Name">
              <p class="text-muted">New channels can be registered from the <a href="{{ route('my_channels')}}">My Channels</a> page.</p>
          </div>
        <div class="col-lg-9 col-md-9">
          <h3>Public Channels</h3>
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>Channel</th>
                <th># Connected</th>
                <th>Now Playing</th>
              </tr>
            </thead>
            <tbody>
              @foreach($channels as $channel)
                <tr>
                  <td><a href="{{ route('channels', $channel->name) }}">{{ $channel->name }}</a>
                  </td>
                  <td>{{ $channel->numbers_of_member }}</td>
                  <td>
                  @php
                    if($channel->link != null) {
                      $idVideo = $channel->link[0];
                      $video = Youtube::getVideoInfo($idVideo);
                      if($video) {
                        echo($video->snippet->title);
                      }else {
                        echo "Dont know";
                      }
                    }                 
                  @endphp
                  </td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>

      </div>
    </section>
@endsection
