<x-layout :title="$user->name">
    <div class="container-fluid py-3">
    <div class="row row-cols-1 row-cols-sm-2 mh-100">
        <div class="col w-auto">
            <div class="mb-3">
                <a href="{{ url()->previous() }}" class="btn btn-sm btn-dark btn-outline-light">
                    <i class="fa-solid fa-arrow-left mr-1"></i> Back
                </a>
            </div>
        </div>
        <div class="container" style="width=100px">
            <div class="col w-auto">
            <div class="container-fluid d-flex justify-content-center fs-1 fw-bolder mb-5" style="margin-top:50px;">Edit Account Information</div>
                <div class="container-fluid d-flex justify-content-center" style="margin-top:50px; margin-bottom:50px;">
                    <div class="row">
                        <div class="col">
                            <svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" fill="black" class="bi bi-person-circle" viewBox="0 0 16 16">
                            <path d="M11 6a3 3 0 1 1-6 0 3 3 0 0 1 6 0"/>
                            <path fill-rule="evenodd" d="M0 8a8 8 0 1 1 16 0A8 8 0 0 1 0 8m8-7a7 7 0 0 0-5.468 11.37C3.242 11.226 4.805 10 8 10s4.757 1.225 5.468 2.37A7 7 0 0 0 8 1"/>
                            </svg>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="row">
                        <div class="col">
                            <div class="font-weight-bold">Name:</div>
                        </div>
                        <div class="col">
                            <div>{{ $user->name }}</div>
                        </div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="row">
                        <div class="col">
                            <div class="font-weight-bold">Email:</div>
                        </div>
                        <div class="col">
                            <div>{{ $user->email }}</div>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="row">
                        <div class="col">
                            <div class="font-weight-bold">Role:</div>
                        </div>
                        <div class="col">
                            <div>{{ $user->role->name }}</div>
                        </div>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="row">
                        <div class="col"><div class="font-weight-bold">Join at:</div></div>
                        <div class="col"><div>{{ $user->created_at }}</div></div>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="row">
                        <div class="col"><div class="font-weight-bold">Status:</div></div>
                        <div class="col">
                        <span class="badge {{ $user->suspended ? 'bg-danger' : 'bg-success' }}">
                            {{ $user->suspended ? 'Suspended' : 'Good' }}
                        </span>
                        @can('check-role', [[1]])
                            <form
                                action="{{ route($user->suspended ? 'unsuspend-user' : 'suspend-user', ['user' => $user->id]) }}"
                                method="post" class="d-inline">
                                @csrf
                                @method('PUT')
                                <button type="submit" class="btn btn-sm {{ $user->suspended ? 'btn-success' : 'btn-danger' }}">
                                    <i class="fa-solid {{ $user->suspended ? 'fa-unlock' : 'fa-lock' }}"></i>
                                    {{ $user->suspended ? 'Unsuspend' : 'Suspend' }}
                                </button>
                            </form>
                        @endcan
                        </div>
                    </div>
                </div>

                @if ($user->role_id === 3)
                    <div class="mb-3">
                        <div class="row">
                            <div class="col"><div class="font-weight-bold">Current Tutor:</div></div>
                            @if ($user->current_tutor)
                            <div class="col">
                                <a href="{{ route('user-profile', ['user' => $user->tutor->id]) }}"
                                    class="text-decoration-none">{{ $user->tutor->name }}</a>
                            </div>
                        @else
                            <div class="col text-danger">No tutor assigned</div>
                        @endif
                        @can('check-role', [[1]])
                            <div class="col"></div>
                        @endcan
                        </div>
                    </div>
                @endif

                <div class="mb-3">
                    <div class="row">
                        <div class="col"><div class="font-weight-bold">Last Updated At:</div></div>
                        <div class="col"><div>{{ $user->updated_at }}</div></div>
                    </div>
                </div>

                <div class="mb-3">
                    <div class="row">
                        <div class="col"><div class="font-weight-bold">Last Login Time:</div></div>
                        <div class="col"><div>{{ $user->last_login_at ?? 'Null' }}</div></div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="row">
                        <div class="col"><div class="font-weight-bold">Last Action Time:</div></div>
                        <div class="col"><div>{{ $user->last_action_at ?? 'Null' }}</div></div>
                    </div>
                </div>

                @if (Auth::user()->id === $user->id)
                    <a href="{{ route('profile.edit') }}" class="btn btn-primary">Edit Profile</a>
                @endif
            </div>
        </div>
        <div class="container" style="margin-top: 50px;">
        @if ($user->role_id === 2)
            <div class="col">
                <div class="border rounded px-4 pb-4">
                    <div class="text-center h4 p-2">Students</div>
                    <ul class="list-group overflow-auto" style="max-height: 60vh">
                        @forelse ($user->students as $student)
                            <li class="list-group-item">
                                <a href="{{ route('user-profile', ['user' => $student->id]) }}"
                                    class="text-decoration-none">
                                    {{ $student->name }}
                                </a>
                            </li>
                        @empty
                            <li class="list-group-item text-center">No Student</li>
                        @endforelse
                    </ul>
                </div>
            </div>
        @endif
        </div>
    </div>

    <div class="container" style="margin-top:50px;">
    <div class="my-3 border rounded p-4 mh-100 overflow-auto">
        <div class="h4 ps-2">Activities</div>
        @php
            $activites = $user->activities()->orderBy('created_at', 'desc')->paginate(10);
        @endphp
        {{ $activites->links() }}
        <ul class="list-group">
            @foreach ($activites as $activity)
                <li class="list-group-item list-group-item-info">

                    <span>{{ $activity->description }}</span>
                    <br>
                    {{-- [<small><b>Type: {{ $activity->type }}</b></small>] --}}
                    {{-- <br> --}}
                    <small>{{ $activity->created_at->diffForHumans() }}</small>
                </li>
            @endforeach
        </ul>
    </div>
    </div>
    </div>
</x-layout>
