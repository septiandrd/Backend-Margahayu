<?php

namespace App\Http\Controllers;

use App\Comment;
use App\Post;
use App\User;
use Illuminate\Http\Request;
use Mockery\Exception;

class PostController extends Controller
{
    public function savePost(Request $request) {
        try {
            $user = User::where('username',$request->username)->first();
            $post = new Post();

            $post->modul = $request->modul;
            $post->question = $request->question;
            $post->username = $user->name;

            $user->score()->save($post);

            return response()->json(['code'=>'SUCCESS']);
        } catch (Exception $exception) {
            return response()->json(['code'=>'FAILED']);
        }
    }

    public function saveComment(Request $request) {
        try {
            $user = User::where('username',$request->username)->first();
            $comment = new Comment();

            $comment->answer = $request->answer;
            $comment->post_id = $request->post_id;
            $comment->username = $user->name;

            $user->comment()->save($comment);

            return response()->json(['code'=>'SUCCESS']);
        } catch (Exception $exception) {
            return response()->json(['code'=>'FAILED']);
        }
    }

    public function getPostByModul(Request $request) {
        try {
            $posts = Post::where('modul',$request->modul)->get();
            return response()->json(compact('posts'));
        } catch (Exception $exception) {
            return response()->json(['code'=>'FAILED']);
        }
    }

    public function getCommentByPost(Request $request) {
        try {
            $comments = Comment::where('post_id',$request->post_id)->get();
            return response()->json(compact('comments'));
        } catch (Exception $exception) {
            return response()->json(['code'=>'FAILED']);
        }
    }
}


