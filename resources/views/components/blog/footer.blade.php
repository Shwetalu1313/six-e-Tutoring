 <div class="d-flex justify-content-between">
     <div class="dropdown">
         <button class="btn btn-sm btn-light border border-dark" data-bs-toggle='dropdown'>
             @if ($blog->myReaction())
                 {{ $blog->myReaction()->emoji->emoji }}
             @else
                 <i class="fa-solid fa-thumbs-up"></i>
             @endif
         </button>
         <ul class="dropdown-menu">
             <script>
                 function reactBlog(blogId, emojiId) {
                     let form = document.createElement('form');
                     form.action = '{{ route('react-blog') }}';
                     form.method = 'POST';
                     form.hidden = true;

                     let input0 = document.createElement('input');
                     input0.name = '_token'
                     input0.value = '{{ csrf_token() }}';
                     form.appendChild(input0);

                     let input1 = document.createElement('input');
                     input1.name = '_blog_id'
                     input1.value = blogId;
                     form.appendChild(input1);

                     let input2 = document.createElement('input');
                     input2.name = 'emoji_id';
                     input2.value = emojiId;
                     form.appendChild(input2);

                     document.body.appendChild(form);
                     form.submit();

                     /* let formData = new FormData();
                     formData.set('_token', "{{ csrf_token() }}");
                     formData.set('_blod_id', blogId);
                     formData.set('emoji_id', emojiId);
                     fetch("{{ route('react-blog') }}", {
                         method: 'POST',
                         body: formData,

                     }); */
                 }
             </script>
             <li class="dropdown-item py-2 overflow-auto" style="max-width: 80vw">
                 @foreach ($emojis as $emoji)
                     <button @class([
                         'btn',
                         'btn-light',
                         'btn-sm',
                         'border',
                         'me-1',
                         'me-sm-2',
                         'active' =>
                             $emoji->id ===
                             ($blog->myReaction() ? $blog->myReaction()->emoji_id : false),
                     ]) onclick="reactBlog({{ $blog->id }},{{ $emoji->id }})">
                         <span class="text-danger">{{ $emoji->emoji }}</span>
                     </button>
                 @endforeach
             </li>
         </ul>
     </div>
     <div class="text-end">
         @if ($blogtype === 'detail')
             <span class="mx-2 openModalBtn" type='button' data-bs-toggle="modal"
                 data-bs-target="#reactionListModal">{{ $blog->reactions->count() }} reactions
             </span>
             |
             <span class="mx-2 openModalBtn" type='button' data-bs-toggle="modal"
                 data-bs-target="#commentListModal">{{ $blog->comments->count() }} comments
             </span>
             @if ($blog->attachments->isNotEmpty())
                 |
                 <span class="mx-2">{{ $blog->attachments->count() }} attachments
                 </span>
             @endif
         @else
             <div class="d-flex">
                 <div class="dropdown">
                     @if ($blog->reactions->isEmpty())
                         <span class="mx-2">0 reactions</span>
                     @else
                         <span class="mx-2 openModalBtn" type='button' data-bs-toggle='dropdown'>
                             {{ $blog->reactions->count() }} reactions
                         </span>
                     @endif
                     <ul @class([
                         'dropdown-menu',
                         'overflow-auto',
                         'py-3' => $blog->reactions->count() === 0,
                     ]) style="max-height:20vh;">
                         @foreach ($blog->reactions as $reaction)
                             <li class="dropdown-item">
                                 <div class="py-2">
                                     <span class="border rounded-3 p-1 me-3">{{ $reaction->emoji->emoji }}</span>
                                     <a href="{{ route('user-profile', ['user' => $reaction->user->id]) }}"
                                         class="text-decoration-none">{{ $reaction->user->name }}
                                     </a>
                                 </div>
                             </li>
                         @endforeach
                     </ul>
                 </div>
                 |
                 <span @class(['mx-2', 'openModalBtn' => $blogtype === 'detail']) data-bs-toggle="modal"
                     data-bs-target="#commentListModal">{{ $blog->comments->count() }} comments
                 </span>
                 @if ($blog->attachments->isNotEmpty())
                     |
                     <span class="mx-2">{{ $blog->attachments->count() }} attachments </span>
                 @endif
             </div>
         @endif
     </div>

 </div>
