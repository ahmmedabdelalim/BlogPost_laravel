<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Traits\GeneralTraits;

class CommentController extends Controller
{
    //
    use GeneralTraits;

    public function create(Request $request)
    { try{
        $comment = Comment::create([
            'body'=>$request->body,
            'user_id'=>$request->user_id,
            'post_id'=>$request->post_id,
        ]);
        return response()->json([
            'id'=>$comment->id,
            'body'=>$comment->body,
            'user'=>$comment->user,


        ]);


    }
    catch(\Exception $ex)
    {
        return $this->returnError($ex->getCode(), $ex->getMessage());
    }
    }


    public function getComment()
    { try{
         $comment= Comment::latest()->with('user')->get();

        return $this->returnData('Comment', $comment);
    }
    catch(\Exception $ex)
    {
        return $this->returnError($ex->getCode(), $ex->getMessage());
    }
    }
}
