<?php

namespace App\Http\Middleware;

use App\Models\Post;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostPublishedValid
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if ($request->post->is_published || auth('sanctum')->check()){
            return $next($request);
        }
        return response(['errors' => [
            'status' =>403,
            'title' =>'unpublished content',
            'detail' =>'unpublished content cannot be viewed',
        ]],403);
    }
}
