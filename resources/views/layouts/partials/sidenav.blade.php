<!-- ms-site-container -->
<div class="ms-slidebar sb-slidebar sb-left sb-style-overlay" id="ms-slidebar">
    <div class="sb-slidebar-container">
        <ul class="ms-slidebar-menu" id="slidebar-menu" role="tablist" aria-multiselectable="true">
            @if (Auth::check())
            <li>
                <a class="link" href="/bytes/create">
                    <i class="zmdi zmdi-plus"></i> Add Byte</a>
            </li>
            <li>
                <a class="link" href="/bytes">
                    <i class="icon-byte-icon2"></i> Byte List</a>
            </li>
            <li class="card" role="tab" id="sch2">
                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#slidebar-menu" href="#sc2" aria-expanded="false" aria-controls="sc2">
                    Lines</a>
                <ul id="sc2" class="card-collapse collapse" role="tabpanel" aria-labelledby="sch2">
                    <li>
                        <a href="/lines/create">Add Lifeline</a>
                    </li>
                    <li>
                        <a href="/lines">My Lifelines</a>
                    </li>
                </ul>
            </li>
                <li class="card" role="tab" id="sch3">
                    <a class="collapsed" role="button" data-toggle="collapse" data-parent="#slidebar-menu" href="#sc3" aria-expanded="false" aria-controls="sc3">
                        Goals</a>
                    <ul id="sc3" class="card-collapse collapse" role="tabpanel" aria-labelledby="sch3">
                        <li>
                            <a href="/goals/create">Add Goal</a>
                        </li>
                        <li>
                            <a href="/goals">My Goals</a>
                        </li>
                        <li>
                            <a href="/lists/create">Add Lifelist</a>
                        </li>
                        <li>
                            <a href="/lists">My Lifelists</a>
                        </li>
                    </ul>
                </li>
            <li class="card" role="tab" id="sch4">
                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#slidebar-menu" href="#sc4" aria-expanded="false" aria-controls="sc4">
                    People</a>
                <ul id="sc4" class="card-collapse collapse" role="tabpanel" aria-labelledby="sch4">
                    <li>
                        <a href="/people/create">Add Person</a>
                    </li>
                    <li>
                        <a href="/people">My People</a>
                    </li>
                </ul>
            </li>
            <li class="card" role="tab" id="sch5">
                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#slidebar-menu" href="#sc5" aria-expanded="false" aria-controls="sc5">
                    Places</a>
                <ul id="sc5" class="card-collapse collapse" role="tabpanel" aria-labelledby="sch5">
                    <li>
                        <a href="/places/create">Add Place</a>
                    </li>
                    <li>
                        <a href="/places">My Places</a>
                    </li>
                </ul>
            </li>

            <li class="card" role="tab" id="sch6">
                <a class="collapsed" role="button" data-toggle="collapse" data-parent="#slidebar-menu" href="#sc6" aria-expanded="false" aria-controls="sc6">
                    Account</a>
                <ul id="sc6" class="card-collapse collapse" role="tabpanel" aria-labelledby="sch6">
                    <li>
                        <a class="dropdown-item" href="/{{ Auth::user()->username }}/edit">Update Profile</a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="/changePassword">Change Password</a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="{{ route('logout') }}"
                           onclick="event.preventDefault();
                               document.getElementById('logout-form').submit();">
                            Logout
                        </a>
                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                            {{ csrf_field() }}
                        </form>
                    </li>
                </ul>
            </li>
            @else
            <li>
                <a class="link" href="{{ route('login') }}">
                    <i class="zmdi zmdi-account"></i> Login</a>
            </li>
            <li>
                <a class="link" href="{{ route('register') }}">
                    <i class="zmdi zmdi-account-add"></i> Register</a>
            </li>
            @endif

        </ul>
    </div>
</div>
</div>
