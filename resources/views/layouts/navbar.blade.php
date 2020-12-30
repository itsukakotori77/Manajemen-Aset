<div class="header">
    <div class="header-left">
        <div class="menu-icon dw dw-menu"></div>
        <div class="search-toggle-icon dw dw-search2" data-toggle="header_search"></div>
    </div>
    <div class="header-right">
        <div class="user-info-dropdown">
            <div class="dropdown">
                <a class="dropdown-toggle" href="#" role="button" data-toggle="dropdown">
                    <span class="user-icon">
                        @if(Auth::user()->avatar == '')
                            <img src="{{ 'https://ui-avatars.com/api/?name='. Auth::user()->username . '&background=0D8ABC&color=fff' }}" alt="">
                        @else
                            <img src="{{  asset('assets/images/foto-user/' . Auth::user()->avatar) }}" alt="">
                        @endif
                    </span>
                    <span class="user-name">{{ Auth::user()->username }}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right dropdown-menu-icon-list">
                    <a class="dropdown-item" href="{{ url('/user/' . Auth::user()->id . '/profile') }}"><i class="dw dw-user1"></i> Profile</a>
                    <a class="dropdown-item" href="#" onclick="logout()" ><i class="dw dw-logout"></i> Log Out</a>
                </div>
            </div>
        </div>
    </div>
</div>