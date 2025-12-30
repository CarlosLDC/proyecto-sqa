<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function dashboard()
    {
        $query = \App\Models\Post::with(['user', 'category'])->latest();

        if (\Illuminate\Support\Facades\Gate::denies('admin')) {
            $query->where('user_id', auth()->id());
        }

        $posts = $query->paginate(10);

        return view('dashboard', compact('posts'));
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = \App\Models\Post::with(['user', 'category'])
            ->where('status', 'published')
            ->latest('published_at')
            ->paginate(9);

        return view('welcome', compact('posts'));
    }

    /**
     * Show the specified resource.
     */
    public function show(\App\Models\Post $post)
    {
        if ($post->status !== 'published') {
            abort(404);
        }

        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = \App\Models\Category::all();
        $users = \Illuminate\Support\Facades\Gate::allows('admin') ? \App\Models\User::all() : [];
        return view('posts.create', compact('categories', 'users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|max:255',
            'category_id' => 'required|exists:categories,id',
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'status' => 'required|in:draft,published',
            'published_at' => 'nullable|date',
            'featured_image' => 'nullable|url',
        ];

        if (\Illuminate\Support\Facades\Gate::allows('admin')) {
            $rules['user_id'] = 'required|exists:users,id';
        }

        $validated = $request->validate($rules);

        if (!\Illuminate\Support\Facades\Gate::allows('admin')) {
            $validated['user_id'] = auth()->id();
        }

        $validated['slug'] = \Illuminate\Support\Str::slug($validated['title']) . '-' . time();

        // Use provided published_at or default to now() if publishing
        if (empty($validated['published_at']) && $validated['status'] === 'published') {
            $validated['published_at'] = now();
        }

        \App\Models\Post::create($validated);

        return redirect()->route('dashboard')->with('success', __('Post created successfully.'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(\App\Models\Post $post)
    {
        if (\Illuminate\Support\Facades\Gate::denies('admin') && $post->user_id !== auth()->id()) {
            abort(403);
        }

        $categories = \App\Models\Category::all();
        $users = \Illuminate\Support\Facades\Gate::allows('admin') ? \App\Models\User::all() : [];

        return view('posts.edit', compact('post', 'categories', 'users'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, \App\Models\Post $post)
    {
        if (\Illuminate\Support\Facades\Gate::denies('admin') && $post->user_id !== auth()->id()) {
            abort(403);
        }

        $rules = [
            'title' => 'required|max:255',
            'category_id' => 'required|exists:categories,id',
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'status' => 'required|in:draft,published',
            'published_at' => 'nullable|date',
            'featured_image' => 'nullable|url',
        ];

        if (\Illuminate\Support\Facades\Gate::allows('admin')) {
            $rules['user_id'] = 'required|exists:users,id';
        }

        $validated = $request->validate($rules);

        if ($validated['title'] !== $post->title) {
            $validated['slug'] = \Illuminate\Support\Str::slug($validated['title']) . '-' . time();
        }

        // Handle published_at logic
        // If date is not provided:
        if (empty($validated['published_at'])) {
            if ($validated['status'] === 'published') {
                // If existing post has date, keep it. Otherwise set to now().
                $validated['published_at'] = $post->published_at ?? now();
            } else {
                // If draft and empty date, ensure it's null
                $validated['published_at'] = null;
            }
        }

        // Prevent non-admins from changing user_id through mass assignment if logic slipped
        if (!\Illuminate\Support\Facades\Gate::allows('admin')) {
            unset($validated['user_id']);
        }

        $post->update($validated);

        return redirect()->route('dashboard')->with('success', __('Post updated successfully.'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(\App\Models\Post $post)
    {
        if (\Illuminate\Support\Facades\Gate::denies('admin') && $post->user_id !== auth()->id()) {
            abort(403);
        }

        $post->delete();

        return redirect()->route('dashboard')->with('success', __('Post deleted successfully.'));
    }
}
