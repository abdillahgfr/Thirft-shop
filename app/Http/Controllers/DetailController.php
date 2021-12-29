<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Post;
use App\User;
use App\Record;
use App\Comment;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DetailController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request, $id)
    {
        $user = User::all();
        $product = Product::with(['galleries', 'user'])->where('slug', $id)->firstOrFail();
        $comments = Comment::with(['product','user'])->whereHas('product', function($product){
                            $product->where('users_id');
                            })->get();
		//Syntax Untuk Rekomendasi
		if(!Auth::guest())
		{
			$product_id = Product::where('slug', $id)->firstOrFail()->id;
			$data = [
				"id"=>Auth::user()->id,
				"product_id"=>$product_id,            
			];
			Record::create($data);
		}
		//End
		
        return view('pages.detail', [
            'product' => $product,
            'user' => $user,
            'comments' => $comments
        ]);
    }

    public function add(Request $request, $id)
    {
        $data = [
            'products_id' => $id,
            'users_id' => Auth::user()->id,
            
        ];

        Cart::create($data);

        return redirect()->route('cart');
    }

    public function show(Product $product)
    {
        
        return view('show', [
            'product' => $product,
            
        ]);
    }
    public function reply(Request $request, $id)
    {
        $user = User::all();
        $product = Product::with(['galleries', 'user'])->where('slug', $id)->firstOrFail();
        $comments = Comment::with(['product','user'])->whereHas('product', function($product){
                            $product->where('users_id', 'child_id', Auth::user()->id);
                            })->get();
		
        return view('pages.detail', [
            'product' => $product,
            'user' => $user,
            'comments' => $comments
        ]);
    }

}
