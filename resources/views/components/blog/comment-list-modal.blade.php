<!-- Modal -->
<div class="modal fade" id="commentListModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">{{ $blog->comments->count() }} Comments</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body overflow-auto" style="max-height: 60vh;">
                <ul class="list-group">
                    @foreach ($blog->comments()->orderBy('created_at', 'desc')->get() as $comment)
                        <li class="list-group-item">
                            <div class="h6">
                                <a href="{{ route('user-profile', ['user' => $comment->author->id]) }}"
                                    class="text-decoration-none">{{ $comment->author->name }}
                                </a>
                                <small> - {{ $comment->created_at->diffForHumans() }}</small>
                                <p>{{ $comment->content }}</p>
                            </div>
                        </li>
                    @endforeach
                </ul>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
