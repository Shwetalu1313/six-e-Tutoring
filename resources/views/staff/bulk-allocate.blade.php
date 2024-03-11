<x-layout>
    <div class="container-fluid fs-1 fw-bolder mb-5" style="margin-top:50px;">Bulk Allocation</div>
    <div class="container-fluid fs-4 d-flex align-items-center fw-normal text-uppercase" style="margin-top:10px; margin-bottom:80px;">
        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-person-badge-fill" viewBox="0 0 16 16">
        <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2zm4.5 0a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1zM8 11a3 3 0 1 0 0-6 3 3 0 0 0 0 6m5 2.755C12.146 12.825 10.623 12 8 12s-4.146.826-5 1.755V14a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1z"/>
        </svg>
        {{ Auth::user()->name }}
    </div>
    <div class="row" style="margin-top:100px; margin-bottom:370px">
        <div class="col-lg-5">
            <div class="border border-2 rounded p-3">
                <div class="h5 ps-1 pb-2">{{ $selectedUsers->count() }} Students</div>
                <ul class="list-group overflow-auto" style="max-height: 40vh;">
                    @forelse ($selectedUsers as $user)
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between">

                                <a href="{{ route('user-profile', ['user' => $user->id]) }}" class="text-decoration-none">
                                    {{ $user->name }}
                                </a>
                                <form action="{{ route('users.toggle-select') }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="_user" value="{{ $user->id }}" />
                                    <button class="btn btn-ghost text-danger">
                                        <i class="fa-solid fa-xmark"></i>
                                    </button>
                                </form>
                            </div>
                        </li>
                    @empty
                        <li class="list-group-item">No Students in bulk</li>
                    @endforelse
                </ul>
            </div>
        </div>

        <div class="col-12 col-lg-2"> </div>

        <div class="col-12 col-lg-5">
            New Tutor

            <form action="{{ route('users.store-bulk-allocation') }}" method="POST">
                @csrf
                @method('PUT')
                {{-- <input type="hidden" name="_student_id" value="{{ $user->id }}"> --}}
                <div class="border border-2 rounded p-3">
                    <select name="tutor_id" class="form-select">
                        <option value="">Choose Tutor</option>
                        @foreach ($tutors as $tutor)
                            <option value="{{ $tutor->id }}">{{ $tutor->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="text-center mt-5">
                    <button href="" class="btn btn-primary">Bulk Allocate</button>
                </div>
            </form>
        </div>
    </div>


</x-layout>
