<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Blog;
use App\Models\BlogAttachment;
use App\Models\BlogReaction;
use App\Models\Emoji;
use App\Models\Activity;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    public function showBlogsAuthoredOrReceived()
    {
        $user = Auth::user();

        $blogs = Blog::where('author_id', $user->id)
            ->orwhere('receiver_id', $user->id)->orderBy('created_at', 'desc')->paginate(10);

        $emojis = Emoji::all();
        $receiver = $user->tutor;
        return view('blog.index', compact('receiver', 'blogs', 'emojis'));
    }
    public function showBlogsBetweenTutorAndStudent(String $id)
    {
        $user = Auth::user();
        $receiver = User::find($id);
        $blogs = Blog::where(function ($query) use ($id) {
            $query->where('author_id', Auth::id())
                ->where('receiver_id', $id);
        })
            ->orWhere(function ($query) use ($id) {
                $query->where('author_id', $id)
                    ->where('receiver_id', Auth::id());
            })->orderBy('created_at', 'desc')->paginate(10);

        $emojis = Emoji::all();
        return view('blog.index', compact('receiver', 'blogs', 'emojis', 'id'));
    }
    public function blogDetail(Blog $blog)
    {
        $emojis = Emoji::all();
        $id = request()->sid;
        return view('blog.detail', compact('blog', 'emojis', 'id'));
    }

    public function create()
    {
        return view('blog.create');
    }

    public function store(Request $request)
    {
        $author_id = Auth::id();
        $receiver_id = Auth::user()->role_id === 3 ? Auth::user()->current_tutor : $request->_receiver_id;

        $validated = $request->validate([
            'files' => 'array|min:0|max:5',
            'files.*' => 'max:' . 2048 * 1024 * 1024,

        ]);

        // dd($validated);

        $blog = new Blog();
        $blog->author_id = $author_id;
        $blog->receiver_id = $receiver_id;
        $blog->title = $request->title;
        $blog->content = $request->content;
        $blog->save();

        $blogId = $blog->id;
        $files = $request->file('files');

        if ($files) {
            foreach ($files as $file) {
                $fileName = uniqid(time()) . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public/uploads', $fileName);
                // $file->store('public/uploads');
                $attachment = new BlogAttachment();
                $attachment->blog_id = $blogId;
                $attachment->name = $file->getClientOriginalName();
                $attachment->path = $fileName;
                $attachment->type = $file->getClientOriginalExtension();
                $attachment->size = $file->getSize();
                $attachment->save();
            }
        }

        Activity::createLog('blog', "Create a blog - $blog->id");

        return Auth::user()->role_id === 3 ? redirect(route('blog-page'))->with('message', 'Blog is uploaded') : redirect(route('blog-page-by-studentId', ['id' => $request->_receiver_id]))->with('message', 'Blog is uploaded');
    }
    public function deleteBlog(Blog $blog)
    {
        $sid = request()->_sid;

        $blog->comments()->delete();
        $blog->reactions()->delete();

        foreach ($blog->attachments as $attachment) {
            Storage::delete('public/uploads' . '/' . $attachment->path);
        }
        $blog->attachments()->delete();
        $success = $blog->delete();

        Activity::createLog('blog', "Delete a blog - $blog->id");


        return (Auth::user()->role_id === 2 ? redirect(route('blog-page-by-studentId', ['id' => $sid])) : redirect(route('blog-page')))->with('message', 'Blog is deleted');
    }
    public function reactBlog(Request $request)
    {
        $reaction = BlogReaction::firstOrNew([
            'user_id' => Auth::id(), //Auth::id(),
            'blog_id' => $request->_blog_id,
        ]);
        $reaction->emoji_id = $request->emoji_id;
        $reaction->save();

        Activity::createLog('blog', "React {$reaction->emoji->emoji} on blog - $request->_blog_id");

        return redirect()->back()->with('message', "You clicked ");

        // return redirect()->back()->with('message', "You clicked {$reaction->emoji->emoji}");

        /*
        $blog_id = $request->blog_id;
        $user_id = $request->user_id; //Get from auth()
        // $emoji_id = $request->emoji_id;

        $reaction = BlogReaction::where('blog_id', $blog_id)->where('user_id', $user_id)->first();
        if ($reaction) {
            $reaction->update(['emoji_id' => $request->emoji_id]);
        } else {
            $reaction = new BlogReaction();
            $reaction->blog_id = $blog_id;
            $reaction->user_id = $user_id;
            $reaction->save();
        }
        */
    }
}
