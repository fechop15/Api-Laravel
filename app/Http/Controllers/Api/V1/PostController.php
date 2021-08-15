<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostCollection;
use App\Http\Resources\PostResource;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('PostPublishedValid')->only('show');
        $this->middleware('auth:sanctum')->only(['store','update','destroy']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        if (auth('sanctum')->check()){
            return new PostCollection(Post::orderBy('id', 'DESC')->paginate(5));
        }else{
            return new PostCollection(Post::where('is_published', true)->orderBy('id', 'DESC')->paginate(5));
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request)
    {
        $post=Post::create([
            'title' => $request->title,
            'content' =>  $request['content'],
            'slug' => Str::slug($request->title),
            'user_id' => auth('sanctum')->user()->id,
            'is_published' => $request->is_published??true,
        ]);
        return (new PostResource($post))
            ->additional(['links' => [
                'self' => url()->full(),
            ]])->response()->setStatusCode(201);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return (new PostResource($post))
            ->additional(['links' => [
                'self' => url()->full(),
            ]]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param Post $post
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        //
        $post->update([
            'title' => $request->title,
            'content' =>  $request['content'],
            'slug' => Str::slug($request->title),
            'user_id' => auth('sanctum')->user()->id,
            'is_published' => $request->is_published??true,
        ]);
        return (new PostResource($post))
            ->additional(['links' => [
                'self' => url()->full(),
            ]])->response()->setStatusCode(202);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
