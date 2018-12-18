@extends('layouts.auth')

@section('content')
<section id="mainpage">
    @if(session()->has('message'))
      <div class="alert alert-success">
          {{ session()->get('message') }}
      </div>
    @endif
    <div class="container">
        <div class="col-lg-6 col-md-6">
            <h3>Register a new channel</h3>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('create_channel')}}" method="POST">
                @csrf
                <input type="hidden" name="" value="">
                <input type="hidden" name="action" value="new_channel">
                <div class="form-group">
                    <label class="control-label" for="channelname">Channel URL</label>
                    <div class="input-group"><span class="input-group-addon"  style="margin-right: 5px; padding-top: 8px">https://bstube.com/</span>
                        <input class="form-control" style="background-color: rgb(26, 26, 26); color: white" id="channelname" type="text" name="name" maxlength="30" onkeyup="checkChannel()" placeholder="Channel ID">
                    </div>
                    <p class="text-danger pull-right" id="validate_channel"></p>
                </div>
                <button class="btn btn-primary btn-block" id="register" type="submit">Register</button>
            </form>
        </div>
        <div class="col-lg-6 col-md-6" style="height: 40px">
        </div>
        <div class="col-lg-6 col-md-6">
        <h3>My Channels</h3>
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>Channel</th>
            </tr>
            </thead>
            <tbody>
            @foreach($my_channels as $channel)
              <tr>
                  <th>
                      <form class="delete" action="{{route('destroy_channel', $channel->name)}}" method="POST"
                            onsubmit="return confirm('Are you sure you want to delete {{$channel->name}}?  This cannot be undone');">
                          <input type="hidden" name="_method" value="DELETE">
                          @csrf
                          <button class="btn btn-sm btn-danger pull-right" type="submit">Delete <span class="glyphicon glyphicon-trash"></span>
                          </button>
                          <a href="{{ route('channels', $channel->name) }}" style="margin-left: 5px">{{$channel->name}}</a>
                      </form>

                  </th>
              </tr>
            @endforeach
            </tbody>
        </table>
        </div>

    </div>
</section>
<script type="text/javascript">

    function checkChannel() {
      function nameIsInvalid(id) {
        if (/\s/.test(id)) {
          return 'Channel URL may not contain spaces';
        }
        if (id === '') {
          return 'Channel URL must not be empty';
        }
        if (!/^[\w-]{1,30}$/.test(id)) {
          return 'Channel URL may only consist of a-z, A-Z, 0-9, - and _';
        }
        return false;
      }

      var box = $("#channelname");
      var value = box.val();
      var lastkey = Date.now();
      box.data("lastkey", lastkey);

      setTimeout(function() {
        if (box.data("lastkey") !== lastkey || box.val() !== value) {
          return;
        }
        if (nameIsInvalid(value)) {
          $('#validate_channel').text(nameIsInvalid(value))
            .parent().addClass('has-error').removeClass('has-success');
          $('#register').addClass('disabled');
        } else {
          $('#validate_channel').text('')
            .parent().addClass('has-success').removeClass('has-error');
          $('#register').removeClass('disabled');
        }
      }, 200);

    }
  </script>
  <div class="selection_bubble_root" style="display: none;"></div>
@endsection
