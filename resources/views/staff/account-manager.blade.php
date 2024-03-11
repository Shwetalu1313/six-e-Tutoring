<x-layout title="Account Manager">
    <script>
        function send(id) {
            $(document).ready(function() {
                $.ajax({
                    url: '{{ route('users.toggle-select') }}',
                    type: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}',
                        _method: 'PUT',
                        _user: id,
                    },
                    error: function(error) {
                        // location.reload();
                    }
                });
            });
        }
    </script>
    <div class="cmy-3 my-5 d-flex justify-content-between flex-md-row flex-column">
        <div class="fs-1 fw-bolder text-center text-md-start">Account Manager</div>
        <div class="fs-4 d-flex align-items-center fw-normal text-uppercase text-center text-md-end" style="color:rgb(103, 103, 101)">
            <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-person-badge-fill" viewBox="0 0 16 16">
                <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2zm4.5 0a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1zM8 11a3 3 0 1 0 0-6 3 3 0 0 0 0 6m5 2.755C12.146 12.825 10.623 12 8 12s-4.146.826-5 1.755V14a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1z"/>
            </svg>
            {{ Auth::user()->name }}
        </div>
    </div>    
    @if ($filterable)
        <div class="">
            <a href="{{ route('register') }}" class="btn btn-success">Register Account</a>
        </div>
    @endif
    @if ($filterable)
        <div class="text-center m-3">
            <div class="btn-group border border-2" role="group" aria-label="Basic example">
                <a href="{{ route('account-manager') }}" @class(['btn', 'btn-primary' => $filterRole === 0])>All</a>
                <a href="{{ route('account-manager', ['role' => 'staff']) }}" @class(['btn', 'btn-primary' => $filterRole === 1])>Staff</a>
                <a href="{{ route('account-manager', ['role' => 'tutor']) }}" @class(['btn', 'btn-primary' => $filterRole === 2])>Tutor</a>
                <a href="{{ route('account-manager', ['role' => 'student']) }}" @class(['btn', 'btn-primary' => $filterRole === 3])>Student</a>
                <a @class([
                    'btn',
                    'btn-primary' => $filterRole === 4,
                    'd-none' => $filterRole !== 4,
                ])>Search</a>
            </div>
        </div>
    @endif
    {{-- <div class="text-end">{{ $users->count() }} Users</div> --}}

    <div style="margin-bottom: 550px;">
        @if ($filterable)
            <div class="mx-auto my-3" style="max-width: 30em;">
                <form action="{{ route('account-manager.search') }}">
                    <div class="input-group">
                        <input type="text" name="searchTerm" id="" class="form-control border-2"
                            value="{{ request()->get('searchTerm') }}" placeholder="Search by name or email" required>
                        <button class="btn btn-primary">Search</button>
                    </div>
                </form>
            </div>
        @endif
        @if ($users->isNotEmpty())
            @can('check-role', [[1]])
                <a href="{{ route('users.unselect-all') }}" class="btn btn-sm btn-danger">Unselect All</a>
                <a href="{{ route('users.create-bulk-allocation') }}" class="btn btn-sm btn-primary">Bulk Allocate</a>
            @endcan
            {{ $users->links() }}
            <div class="table-responsive-sm">
                    <table class="table">
                        <thead>
                            <tr>
                                <th> </th>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Role</th>
                                @if ($filterRole == 0 || $filterRole == 3)
                                    <th>Tutor</th>
                                @endif
                                <!-- <th>Email Verified</th> -->
                                <th>Join Datetime</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach ($users as $user)
                                <tr>
                                    <td>
                                        @can('check-role', [[1]])
                                            @if ($user->role_id === 3)
                                                <input type="checkbox" @checked(in_array($user->id, session()->get('selectedUsers')))
                                                    onclick='send({{ $user->id }})'>
                                            @endif
                                        @endcan
                                    </td>

                                    <td>{{ $user->id }}</td>
                                    <td>
                                        <a href="{{ route('user-profile', ['user' => $user->id]) }}"
                                            class="text-decoration-none">
                                            {{ $user->name }}
                                        </a>
                                    </td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->role->name }}</td>
                                    @if ($filterRole == 0 || $filterRole == 3)
                                        <td>
                                            <div>
                                                @if ($user->role_id == 3)
                                                    @if ($user->current_tutor)
                                                        <a href="{{ route('user-profile', ['user' => $user->tutor->id]) }}"
                                                            class="text-decoration-none">
                                                            {{ $user->tutor ? $user->tutor->name : '' }}
                                                        </a>
                                                    @else
                                                        <span class="text-danger">No tutor assigned</span>
                                                    @endif
                                                    @can('check-role', [[1]])
                                                        <a href="{{ route('edit-tutor', ['user' => $user->id]) }}"
                                                            class="btn btn-sm btn-outline-primary"><i
                                                                class="fa-solid fa-pencil"></i>
                                                        </a>
                                                    @endcan
                                                @endif
                                            </div>
                                        </td>
                                    @endif
                                    <td>{{ $user->created_at }}</td>
                                    <td>
                                        <span class="{{ $user->suspended ? 'text-danger' : 'text-success' }}">
                                            {{ $user->suspended ? 'Suspended' : 'Good' }}
                                        </span>
                                    </td>
                                    @can('check-role', [[1]])
                                        <td>
                                            <form
                                                action="{{ route($user->suspended ? 'unsuspend-user' : 'suspend-user', ['user' => $user->id]) }}"
                                                method="post">
                                                @csrf
                                                @method('PUT')
                                                @if ($user->suspended)
                                                    <button class="btn btn-sm btn-danger">
                                                        <i class="fa-solid fa-lock"></i>
                                                    </button>
                                                @else
                                                    <button class="btn btn-sm btn-primary">
                                                        <i class="fa-solid fa-unlock"></i>
                                                    </button>
                                                @endif
                                            </form>
                                        </td>
                                    @endcan
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
        @else
            <div class="text-center">No User</div>
        @endif
    </div>
</x-layout>
