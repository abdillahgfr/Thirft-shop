<?php

namespace App\Http\Controllers;


use App\Comment;
use Illuminate\Support\Facades\Auth;

class DashboardCommentController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $comment = Comment::all();
        $comments = Comment::with(['product','user'])->whereHas('product', function($product){
                            $product->where('users_id', Auth::user()->id);
                            })->get();
        
        return view('pages.dashboard-comments', compact('user','comment','comments'));
       
    }


}
