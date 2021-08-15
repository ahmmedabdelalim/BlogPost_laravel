<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Traits\GeneralTraits;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    //
    use GeneralTraits;

    /*public function __construct()
    {
        $this->middleware('is_admin');
    }*/

    public function getPosts()
    {
        try{

            $posts = Post::latest()->with('user')->with('category')->get();

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


    public function addpost(Request $request)
    {
        try{
        $file_path = "";

        if($request->has('image'))
        {
            $file_path =  $this->returnImage('posts',$request->image);
        }
        $post = Post::create([
            'title'=>$request->title,
            'slug'=>  Str::slug($request->title),
            'body'=> $request->body,
            'user_id'=>$request->user_id,
            'category_id'=>$request->category,
            'image' => $file_path,


        ]);
        return $this->returnData('Post', $post);
    }
    catch(\Exception $ex)
    {
        return $this->returnError($ex->getCode(), $ex->getMessage());
    }
    }


    public function updatepost(Request $request)
    {
        try{
            $post = Post::find($request->id);
              $file_path =$post->image;

            if($request->has('image'))
            {
                $file_path =  $this->returnImage('posts',$request->image);


            }

            $post->title = $request->title;
            $post->slug =  Str::slug($request->title);
            $post->body = $request->body;
            $post->category_id=$request->category;
            $post->image = $file_path !=    null ? $file_path : $post->image;
            $post ->save();

            return $this->returnData('Post', $post);
        }
        catch(\Exception $ex)
        {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }


    public function deletePost(Request $request)
    {
        try {
           $ids = $request->posts_ids;
           DB::table('posts')->whereIn('id',$ids)->delete();



        } catch (\Exception $ex) {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }
    }


}
