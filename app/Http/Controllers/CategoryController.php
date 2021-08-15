<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Traits\GeneralTraits;
use App\Models\Category;
use App\Models\Post;

class CategoryController extends Controller
{
    //

    use GeneralTraits;
    public function show_category()
    {
        try{
        $category = Category::has('post')->get();

        return $this->returnData('Category', $category);
        }
        catch(\Exception $ex)
        {
            return $this->returnError($ex->getCode(), $ex->getMessage());
        }

    }


    public function categoryPosts($slug)
    {
        $category = Category::whereSlug($slug)->first();
        $posts = Post::whereCategoryId($category->id)->with('user')->get();
        foreach($posts as $post)
        {
            $post->setAttribute('AddedAt',$post->created_at->diffForHumans());
            $post->setAttribute('comment_count',$post->comment->count());
        }
        return $this->returnData('Post', $posts);

    }
}
