<x-layout title="Create Blog">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="container-fluid fs-1 fw-bolder mb-5" style="margin-top:50px;">Create Blog</div>
    <div class="container-fluid fs-4 d-flex align-items-center fw-normal text-uppercase" style="margin-top:10px; margin-bottom:80px;">
        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-person-badge-fill" viewBox="0 0 16 16">
        <path d="M2 2a2 2 0 0 1 2-2h8a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2zm4.5 0a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1zM8 11a3 3 0 1 0 0-6 3 3 0 0 0 0 6m5 2.755C12.146 12.825 10.623 12 8 12s-4.146.826-5 1.755V14a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1z"/>
        </svg>
        {{ Auth::user()->name }}
    </div>
    <form action="{{ route('store-blog') }}" method="POST" enctype="multipart/form-data"
        onsubmit="(()=>{this.content.value = quill.container.firstChild.innerHTML })()">
        @csrf
        <input type="hidden" name="_receiver_id" value="{{ request()->get('receiver_id') }}">
        <input type="text" name="title" class="form-control mb-3" placeholder="Title" required>
        <div id="editor" class="mb-3"> </div>
        <script>
            var quill = new Quill('#editor', {
                theme: 'snow'
            });
        </script>
        <textarea name="content" rows="5" class="form-control mb-3" placeholder="What's on your mind" hidden></textarea>
        <input type="file" name="files[]" class="form-control" multiple>
        <div class="text-center mt-3">
            <button class="btn btn-primary">Upload</button>
        </div>
    </form>
</x-layout>
