<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\BlogComment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BlogCommentController extends Controller
{
    public function store(Request $request)
    {
        $comment = new BlogComment();
        $comment->blog_id = $request->_blog_id;
        $comment->author_id = Auth::id();
        $comment->content = $request->content;
        $comment->save();
        Activity::createLog('Blog Comment', "Commented under the blog - $request->_blog_id");

        // return redirect()->route('blog-detail', ['blog' => $request->_blog_id])->with('message', 'Commented');
        return redirect()->back()->with('message', 'Commented');
    }
    public function destroy(BlogComment $comment)
    {
        $success = $comment->delete();
        return $success ? redirect()->back()->with('message', 'Comment from blog is deleted') :
            redirect()->back()->with('error', 'Failed to delete comment from blog');
    }
}
