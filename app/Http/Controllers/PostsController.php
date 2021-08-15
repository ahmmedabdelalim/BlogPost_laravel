<?php

namespace App\Http\Controllers;

use App\Http\Traits\GeneralTraits;
use Illuminate\Http\Request;
use App\Models\Post ;

class PostsController extends Controller
{
    //

    use GeneralTraits;

    public function index()
    {
        try{

            $posts = Post::latest()->with('user')->get();
            foreach($posts as $post)
            {
                $post->setAttribute('AddedAt',$post->created_at->diffForHumans());
                $post->setAttribute('comment_count',$post->comment->count());
            }
            return $this->returnData('Post', $posts);


        }
        catch(\Exception $ex)
        {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }

    }

    public  function show(Post $post)
    {
        /* $posts=Post::with('user')->find($slug);
         if(!$posts)
         {
            return $this->returnError("E001","not found item");
         }*/

        return $this->returnData('Post',  [
            'id'=>$post->id,
            'title'=>$post->title,
            'slug'=>$post->slug,
            'body'=>$post->body,
            'image'=>$post->image,
            'category'=>$post->category,
            'added_at'=>$post->created_at->diffForHumans(),
            'comments_count'=>$post->comment->count(),
            'user'=>$post->user,
            'comments'=>$post->comment->map(function ($comment) {
                return [
                    'id'=>$comment->id,
                    'body'=>$comment->body,
                    'user'=>$comment->user,
                    'added_at'=>$comment->created_at->diffForHumans()
                ];
            })
        ]);

    }

    public function CommentsFormatted($comments)
    {
        $new_comments = [];
        foreach($comments as $comme)
        {
            array_push($new_comments,[
                'id'=>$comme->id,
                 'body'=>$comme->body,

                 'added_at'=>$comme->created_at->diffForHumans(),
                 'user'=>$comme->user,

            ]);

            return $new_comments;
        }
    }


    public function searchposts($query)
    {
        $posts = Post::where('title','like','%'.$query.'%')->with('user')->get();
        foreach($posts as $post)
        {
            $post->setAttribute('AddedAt',$post->created_at->diffForHumans());
            $post->setAttribute('comment_count',$post->comment->count());
        }
        return $this->returnData('Post', $posts);
    }
}
