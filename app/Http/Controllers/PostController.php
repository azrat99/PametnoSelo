<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Post;

class PostController extends Controller
{
    public function create()
    {
        return view('posts.create');
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        if ($user->is_worker != 1) {
            $validator = Validator::make($request->all(), [
                'title' => ['required', 'string', 'max:255'],
                'description' => ['required', 'string'],
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            $post = new Post();
            $post->title = $request->input('title');
            $post->description = $request->input('description');
            $post->user_id = $user->id;
            $post->save();

            return redirect()->back()->with('success', 'Post created successfully!');
        }

        return redirect()->back()->with('error', 'Only non-workers can create posts!');
    }

    public function acceptTask(Post $post)
    {
        $user = Auth::user();

        $post->worker()->associate($user);
        $post->save();

        return redirect()->back()->with('success', 'Post accepted successfully!');
    }

    public function finishTask(Post $post)
    {
        $post->update(['status' => 1]);

        return redirect()->back()->with('success', 'Post marked as finished!');
    }
}
