<?php

namespace App\Http\Controllers;

use App\Models\Post;
//use App\Settings;
//use App\Vote;
use Illuminate\Http\Request;

class ApiController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
    }

    public function posts()
    {
        $posts = Post::whereIn('status', ['ok', 'public'])
            ->has('user')
            ->latest()
            ->get();
        return $posts->map(function(Post $post) {
            return [
                'user' => $post->user->name ?? '',
                'text' => $post->text ?? '',
                'name' => $post->name ?? '',
                'date' => isset($post->created_at) ? $post->created_at->format('U') : '',
            ];
        })->toJson();
    }

    public function newPost(Request $request)
    {
        $this->validate($request, [
            'text' => 'required|string',
            'name' => 'nullable|string'
        ]);
        $text = $request->post('text');
        $name = $request->post('name');
        $post=Post::create([
            'text' => $text,
            'user_id' => 1,
            'name' => $name,
        ]);
        return $post->toJson();
    }
}
