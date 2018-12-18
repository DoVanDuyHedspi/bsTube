<nav class="navbar-header-custom" role="navigation" style="">
    <div class="container-custom">
        <a class="navbar-brand" href="{{ route('root') }}" style="color: white">
            {{ config('app.name', 'Laravel') }}
        </a>
        <div class="collapse navbar-collapse" id="nav-collapsible">
            <div class="visible-lg">
                <div class="navbar-form navbar-right">
                        <a class="dropdown-toggle" href="#" data-toggle="dropdown">{{ Auth::user()->username }}<b class="caret"></b></a>
                        <ul class="dropdown-menu">
                                <li>
                                    <a href="{{ route('my_channels')}}">My Channel</a>
                                    <a href="{{ route('users', Auth::user()->username)}}">Profile</a>
                                    <a href="{{route('changePassword')}}">Change Password</a>
                                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </li>
                        </ul>
                </div>
            </div>
        </div>
    </div>
</nav>
