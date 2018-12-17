@extends('layouts.auth')

@section('content')
<div class="container" style="margin-top: 100px;">
    <h2 class="text-primary">{{ $user->username }}</h2>
    <hr>
    @if(Auth::user()->isNotTheUser($user))
        @if(Auth::user()->isFollowing($user))
            <a href="{{ route('users.unfollow', $user) }}" class="btn btn-primary">unfollow</a>
        @else
            <a href="{{ route('users.follow', $user) }}" class="btn btn-success">follow</a>
        @endif
    @endif
</div>
@endsection
