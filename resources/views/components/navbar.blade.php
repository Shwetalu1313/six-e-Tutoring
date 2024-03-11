@php
$active = true;

@endphp

<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
    <div class="container-fluid">
        <a class="navbar-brand fs-3 fw-normal text-light" href="/">Six</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                {{-- Profile --}}
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                        aria-expanded="false">
                        Profile
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="{{ route('user-profile', ['user' => Auth::id()]) }}">
                                {{ Auth::user()->name }}</a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li class="dropdown-item text-danger">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <input type="submit" value="Log Out"
                                    class="btn btn-link text-danger text-decoration-none" />
                            </form>

                            {{-- <a href="{{ route('user-profile', ['user' => Auth::id()]) }}">
                                Logout</a> --}}
                        </li>
                    </ul>
                </li>

                {{-- Staff --}}
                @can('check-role', [[1]])
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Staff Actions
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('dashboards.staff') }}">Staff Dashboard</a></li>
                            <li><a class="dropdown-item" href="{{ route('account-manager') }}">Account Manager</a></li>
                            <li><a class="dropdown-item" href="{{ route('emoji-manager') }}">Emoji Manager</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item" href="#">Something else here</a></li>
                        </ul>
                    </li>
                @endcan

                {{-- Tutor --}}
                @can('check-role', [[2]])
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Tutor Actions
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('dashboards.tutor') }}">Tutor Dashboard</a></li>
                        </ul>
                    </li>
                @endcan
                {{-- Student --}}

                @can('check-role', [[3]])
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            Student Actions
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('dashboards.student') }}">Student Dashboard</a></li>
                        </ul>
                    </li>
                @endcan
                @if(in_array(Auth::user()->role_id, [2, 3]))
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown"
                           aria-expanded="false">
                            My Schedule
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('schedule.index') }}">Create</a></li>
                            <li><a class="dropdown-item" href="{{ route('schedule.manager') }}">Schedule Manager</a></li>
                            <li><a class="dropdown-item" href="{{ route('share.index') }}">Shared Schedules</a></li>
                        </ul>
                    </li>
                @endif

            </ul>

        </div>
    </div>
</nav>
