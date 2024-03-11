<x-layout>
    <div class="container-fluid fs-1 fw-bolder mb-5" style="margin-top:50px;">Blog Detail</div>
    <div class="container">
        <div class="my-3 d-flex justify-content-between">
            <div class="h6">
                <a href="{{ route('user-profile', ['user' => $blog->author_id]) }}"class="text-decoration-none">
                    <div class="">{{ $blog->author->name }}</div>
                </a>
                <small class="text-muted">{{ $blog->created_at->diffForHumans() }}</small>
            </div>
            <div class="dropdown">
                <button class="btn btn-sm btn-secondary w-100" data-bs-toggle='dropdown'>
                    <i class="fa-solid fa-ellipsis"></i>
                </button>
                <ul class="dropdown-menu">
                    @can('delete-blog', $blog)
                        <form action="{{ route('delete-blog', ['blog' => $blog->id]) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <li class="dropdown-item">
                                <input type="hidden" name="_sid" value="{{ isset($id) ? $id : null }}" />
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
        <h6>{{ $blog->title }}</h6>
        <p class="mb-4" id="content"></p>
        <script>
            function decodeHtml(html) {
                let txt = document.createElement("textarea");
                txt.innerHTML = html;
                return txt.value;
            }

            $(document).ready(function() {
                $('#content').html(decodeHtml("{{ $blog->content }}"));

            })
        </script>
        @if ($blog->attachments->isNotEmpty())
            <div>
                <hr>
                <div class="accordion" id="accordionExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                Attachments - {{ $blog->attachments->count() }} files
                            </button>
                        </h2>
                        <div id="collapseOne" class="accordion-collapse collapse show"
                            data-bs-parent="#accordionExample">
                            <div class="accordion-body">
                                <div class="d-flex flex-column flex-md-row p-2 flex-wrap gap-3">
                                    @foreach ($blog->attachments as $attachment)
                                        <div class="border border-secondary rounded p-2">
                                            <a href="{{ asset('storage/uploads/' . $attachment->path) }}"
                                                class="btn" download><i class="fa-solid fa-download"></i>
                                                {{ $attachment->name }}
                                                <br>
                                                {{ round($attachment->size / 1024, 1) }} KB
                                            </a>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>

                </div>


                <div class='collapse' id='attachmentContainer'>

                </div>
                <hr>
            </div>
        @endif

        <x-blog.footer :$blog :$emojis blogtype='detail' />
        <x-blog.reaction-list-modal :$blog />
        <x-blog.comment-list-modal :$blog />
        <hr>
        <form action="{{ route('store-blogcomment') }}" method="POST">
            @csrf
            <input type="hidden" name="_blog_id" value="{{ $blog->id }}">
            <textarea name="content" id="" class="form-control border-dark" placeholder="Leave the comment here" required></textarea>
            <div class="text-center my-3">
                <button class="btn btn-sm btn-primary">Comment</button>
            </div>
        </form>

        <div class="fw-semibold fs-4 text-primary mt-4">{{ $blog->comments->count() }} Comments</div>
        @foreach ($blog->comments()->orderBy('created_at', 'desc')->get() as $comment)
            <div class="border border-success-subtle border-dark rounded p-3 my-3">
                <div class="d-flex justify-content-between">
                    <div class="h6 mb-2">
                        <a href="{{ route('user-profile', ['user' => $comment->author_id]) }}"
                            class="text-decoration-none">
                            <span class="">{{ $comment->author->name }}</span>
                        </a>
                        <small class="text-muted"> - {{ $comment->created_at->diffForHumans() }}</small>
                    </div>
                    <div class="dropdown">
                        <button class="btn btn-sm btn-secondary" data-bs-toggle='dropdown'>
                            <i class="fa-solid fa-ellipsis-vertical px-1"></i>
                        </button>
                        <ul class="dropdown-menu">
                            @can('delete-blogcomment', $comment)
                                <form action="{{ route('delete-blogcomment', ['comment' => $comment->id]) }}"
                                    method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <li class="dropdown-item">
                                        <button class="btn w-100"><span class="text-danger">Delete</span></button>
                                    </li>
                                </form>
                            @endcan
                        </ul>
                    </div>
                </div>
                {{ $comment->content }}
            </div>
        @endforeach
    </div>
</x-layout>
