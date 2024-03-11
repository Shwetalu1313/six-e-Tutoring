<!-- Modal -->
<div class="modal fade" id="reactionListModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">{{ $blog->reactions->count() }} Reactions</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body overflow-auto" style="max-height: 60vh;">
                <ul class="list-group">
                    @foreach ($blog->reactions as $reaction)
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between align-items-center">
                                <a href="{{ route('user-profile', ['user' => $reaction->user->id]) }}"
                                    class="text-decoration-none">
                                    {{ $reaction->user->name }}
                                </a>
                                <span class="border rounded-3 p-1">{{ $reaction->emoji->emoji }}</span>
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
