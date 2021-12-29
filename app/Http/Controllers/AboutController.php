<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Support\Facades\Auth;


class AboutController extends Controller
{
    public function index()
    {  
        $comments = Comment::with(['product','user'])->whereHas('product', function($product){
                            $product->where('users_id');
                            })->get();
        
        return view('pages.about', compact('comments'));
    }

}

