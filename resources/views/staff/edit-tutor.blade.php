<x-layout>
    <div class="container-fluid fs-1 fw-bolder mb-5" style="margin-top:50px;">Edit Tutor</div>
    <div class="container-fluid fs-4 d-flex align-items-center fw-normal text-uppercase" style="margin-top:10px; margin-bottom:80px;">
        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-person-badge-fill" viewBox="0 0 16 16">
        <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2zm4.5 0a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1zM8 11a3 3 0 1 0 0-6 3 3 0 0 0 0 6m5 2.755C12.146 12.825 10.623 12 8 12s-4.146.826-5 1.755V14a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1z"/>
        </svg>
        {{ Auth::user()->name }}
    </div>
    <div class="container" style="margin-bottom: 280px;">
        <div>
            <div class="mb-3 fs-5 fw-normal">For Student:</div>
            <div class="border border-2 rounded p-2" style="width: max-content">
                {{ $user->name }}
                <span class="text-muted text-sm">{{ $user->role->name }}</span>
            </div>
        </div>
        <div class="row my-3">
            <div class="col-lg-5">
                <div class="mb-3 fs-5 fw-normal">Current Tutor:</div>
                
                <div class="border border-2 rounded p-3">
                    @if (!$user->current_tutor)
                        <span class="text-danger"> No tutor assigned right now. </span>
                    @else
                        <span>{{ $user->tutor->name }}</span>
                    @endif
                </div>
            </div>

            <div class="col-12 col-lg-2"> </div>

            <div class="col-12 col-lg-5">
                <div class="mb-3 fs-5 fw-normal">New Tutor:</div>
                <form action="{{ route('update-tutor', ['user' => $user->id]) }}" method="POST">
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
                        <button href="" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


</x-layout>
