<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;

class PostController extends Controller
{
    public function publicPosts(Request $request, $category = null)
    {
        $categories = Category::all();

        $posts = Post::where('visibility', 'public')
            ->when($category, function ($query) use ($category) {
                $query->whereHas('category', function ($q) use ($category) {
                    $q->where('name', $category);
                });
            })
            ->when($request->search, function ($query) use ($request) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'LIKE', "%{$search}%")
                        ->orWhere('user_id', $search);
                });
            })
            ->with(['comments.user'])
            ->latest()
            ->paginate(7);

        return view('public-posts', compact('posts', 'categories', 'category'));
    }

    public function home()
    {
        $user = auth()->user();

        $posts = Post::with('user')
            ->where('user_id', $user->id)
            ->where('visibility', 'private')
            ->latest()
            ->get();
        $categories = Category::all();

        return view('home', compact('user', 'posts', 'categories'));
    }

    public function deletePost(Post $post)
    {
        if (auth()->user()->id === $post['user_id']) {
            $post->delete();
        }
        return redirect('/');
    }

    public function actuallyUpdatePost(Post $post, Request $request)
    {
        if (auth()->user()->id !== $post['user_id']) {
            return redirect('/');
        }

        $incomingFields = $request->validate([
            'title' => 'required',
            'body' => 'required'
        ]);

        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);

        $post->update($incomingFields);
        return redirect('/');
    }

    public function showEditScreen(Post $post)
    {
        if (auth()->user()->id !== $post['user_id']) {
            return redirect('/');
        }

        return view('edit-post', ['post' => $post]);
    }

    public function createPost(Request $request)
    {
        $incomingFields = $request->validate([
            'title' => 'required',
            'body' => 'required',
            'visibility' => 'required|in:public,private',
            'category_id' => 'required|exists:categories,id',
        ]);

        $incomingFields['title'] = strip_tags($incomingFields['title']);
        $incomingFields['body'] = strip_tags($incomingFields['body']);
        $incomingFields['user_id'] = auth()->id();

        Post::create($incomingFields);
        return redirect('/');
    }
}
