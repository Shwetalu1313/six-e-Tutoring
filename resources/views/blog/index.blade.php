<x-layout>
    <style>
        .blog:hover {
            background-color: rgb(238, 245, 251);
        }
    </style>
    <div class="container-fluid mt-5 d-flex align-items-center fs-1 fw-bolder ">
        <svg xmlns="http://www.w3.org/2000/svg" width="35" height="35" fill="black" class="bi bi-house-door-fill" viewBox="0 0 16 16">
        <path d="M6.5 14.5v-3.505c0-.245.25-.495.5-.495h2c.25 0 .5.25.5.5v3.5a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5v-7a.5.5 0 0 0-.146-.354L13 5.793V2.5a.5.5 0 0 0-.5-.5h-1a.5.5 0 0 0-.5.5v1.293L8.354 1.146a.5.5 0 0 0-.708 0l-6 6A.5.5 0 0 0 1.5 7.5v7a.5.5 0 0 0 .5.5h4a.5.5 0 0 0 .5-.5"/>
        </svg>
        Dashboard
    </div>
    <div class="container-fluid mt-5">
        <div class="fs-3 fw-bold mb-1 d-flex align-items-center">Hello {{ Auth::user()->name }},</div>
        <div class="fs-4 fw-normal mb-3 d-flex align-items-center">
                <div class="container-fuild" style="width: 160px;">Welcome back</div>
                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="black" class="bi bi-emoji-wink-fill" viewBox="0 0 16 16">
                <path d="M8 0a8 8 0 1 1 0 16A8 8 0 0 1 8 0M7 6.5C7 5.672 6.552 5 6 5s-1 .672-1 1.5S5.448 8 6 8s1-.672 1-1.5M4.285 9.567a.5.5 0 0 0-.183.683A4.5 4.5 0 0 0 8 12.5a4.5 4.5 0 0 0 3.898-2.25.5.5 0 1 0-.866-.5A3.5 3.5 0 0 1 8 11.5a3.5 3.5 0 0 1-3.032-1.75.5.5 0 0 0-.683-.183m5.152-3.31a.5.5 0 0 0-.874.486c.33.595.958 1.007 1.687 1.007s1.356-.412 1.687-1.007a.5.5 0 0 0-.874-.486.93.93 0 0 1-.813.493.93.93 0 0 1-.813-.493"/>
                </svg>
        </div>
    </div>
    @if ($receiver)
        <div class="ps-1 my-5 fs-5 fw-normal" style="width: max-content">
            <span class=""><small>Receiver</small></span> -
            <a href="{{ route('user-profile', ['user' => $receiver->id]) }}" class="text-decoration-none">
                {{ $receiver->name }}
            </a>
        </div>
    @else
        <div>{{ Auth::user()->role_id !== 3 ? 'Receiver not found' : 'No tutor assigned yet for you.' }}</div>
    @endif
    <hr>
    @can('upload-blog', isset($id) ? [$id] : [])
        <a href="{{ route('create-blog', isset($id) ? ['receiver_id' => $id] : []) }}" class="mb-5 btn btn-primary">
            <span class=""> Upload Blog</span>
        </a>
    @else
        <div class="text-danger">You can't upload blog</div>
    @endcan
    {{ $blogs->links() }}
    @foreach ($blogs as $blog)
        <div class="border border-dark rounded p-2 mb-3 blog">
            <div class="d-flex justify-content-between">
                <div class="h6">
                    <a class="text-decoration-none" href="{{ route('user-profile', ['user' => $blog->author->id]) }}">
                        <div>{{ $blog->author->name }}</div>
                    </a>
                    <small class="text-muted">{{ $blog->created_at->diffForHumans() }}</small>
                </div>
                <div class="dropdown">
                    <button class="btn btn-sm btn-secondary" data-bs-toggle='dropdown'>
                        <i class="fa-solid fa-ellipsis"></i>
                    </button>
                    <ul class="dropdown-menu">
                        @can('delete-blog', $blog)
                            <form action="{{ route('delete-blog', ['blog' => $blog->id]) }}" method="POST">
                                @csrf
                                @method('DELETE')
                                <li class="dropdown-item">
                                    <input type="hidden" name="_sid" value="{{ isset($id) ? $id : 0 }}">
                                    <button class="btn w-100"><span class="text-danger">Delete</span></button>
                                </li>
                            </form>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                        @endcan
                        <li class="dropdown-item">
                            <div>
                                <small>
                                    Who can see this blog <i class="fa-solid fa-eye"></i>
                                    <a class="text-decoration-none"
                                        href="{{ route('user-profile', ['user' => $blog->author->id]) }}">
                                        <div>{{ $blog->author->name }}</div>
                                    </a>
                                    <a class="text-decoration-none"
                                        href="{{ route('user-profile', ['user' => $blog->author->id]) }}">
                                        <div>{{ $blog->receiver->name }}</div>
                                    </a>
                                </small>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
            <div onclick="location.href='{{ route('blog-detail', ['blog' => $blog->id, 'sid' => isset($id) ? $id : null]) }}'"
                style="cursor: pointer;" class="blog-body">
                <h6>{{ $blog->title }}</h6>
                <p>
                    {!! substr($blog->content, 0, 200) !!}
                    @if (strlen($blog->content) > 200)
                        <a class="text-decoration-none" href="{{ route('blog-detail', ['blog' => $blog->id]) }}">see
                            more</a>
                    @endif
                </p>
            </div>
            <x-blog.footer :$blog :$emojis blogtype='overview' />
        </div>
    @endforeach
    {{-- <x-blog.reaction-list-modal :$blog /> --}}
    {{-- <x-blog.comment-list-modal :$blog /> --}}
</x-layout>
