<?php

namespace App\Http\Controllers;

use App\Models\Review;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function create()
    {
        $post = Post::with('worker')->where('user_id', Auth::user()->id)->first();

        return view('reviews.create', [
            'post' => $post
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'worker_id' => 'required|exists:users,id',
            'description' => 'required',
            'grade' => 'required|integer|min:1|max:5',
        ]);

        $review = new Review();
        $review->user_id = Auth::id();
        $review->worker_id = $request->input('worker_id');
        $review->description = $request->input('description');
        $review->grade = $request->input('grade');
        $review->save();

        return redirect()->route('dashboard')->with('success', 'Review submitted successfully!');
    }

    public function edit(Review $review)
    {
        if ($review->user_id !== auth()->user()->id) {
            abort(403); // Unauthorized user
        }

        $post = Post::with('worker')->where('user_id', Auth::user()->id)->first();

        return view('reviews.edit', compact('review', 'post'));
    }

    public function update(Request $request, Review $review)
    {
        if ($review->user_id !== auth()->user()->id) {
            abort(403); // Unauthorized user
        }

        $validatedData = $request->validate([
            'worker_id' => 'required|exists:users,id',
            'description' => 'required',
            'grade' => 'required|numeric|between:1,5',
        ]);

        $review->update($validatedData);

        return redirect()->route('dashboard')->with('success', 'Review updated successfully!');
    }
}
