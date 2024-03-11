<x-layout>
    <div class="container-fluid fs-1 fw-bolder mb-5" style="margin-top:50px;">Emoji Manager</div>
    <div class="container-fluid fs-4 d-flex align-items-center fw-normal text-uppercase" style="margin-top:10px; margin-bottom:150px;">
        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-person-badge-fill" viewBox="0 0 16 16">
        <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2zm4.5 0a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1zM8 11a3 3 0 1 0 0-6 3 3 0 0 0 0 6m5 2.755C12.146 12.825 10.623 12 8 12s-4.146.826-5 1.755V14a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1z"/>
        </svg>
        {{ Auth::user()->name }}
    </div>
    <form action="{{ route('store-emoji') }}" method="POST">
        @csrf
        <div class="input-group m-auto" style="max-width: 30em;">
            <input type="text" name="emoji" class="form-control" required>
            <button class="btn btn-primary">Add</button>
        </div>
    </form>
    <div class="container" style="margin-bottom:320px">
        <div class="p-3 my-5 border border-secondary rounded">
            <div class="d-flex flex-wrap">
                @forelse ($emojis as $emoji)
                    <div class="p-2 me-2 my-2 border rounded text-center" style="min-width: 2.5em">{{ $emoji->emoji }}
                        {{-- <a href="{{ route('delete-emoji', ['emoji' => $emoji->id]) }}" class="btn">Del</a> --}}
                    </div>
                @empty
                    <div class="h3 text-center muted">No emoji added yet now</div>
                @endforelse
            </div>
        </div>
    </div>

</x-layout>
