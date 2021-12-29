<?php

namespace App\Http\Controllers;

use App\Cart;
use App\Comment;
use App\Models\Province;
use Illuminate\Http\Request;
Use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $users_id = Auth::user()->id;
        $user = Auth::user();
        $carts = Cart::with(['product.galleries', 'user'])->where('users_id', $users_id)
                        ->get();
        $provinces = Province::all();
        $comments = Comment::with(['product','user'])->whereHas('product', function($product){
                            $product->where('users_id', Auth::user()->id);
                            })->get();
        return view('pages.cart', compact('carts','user','provinces', 'comments'));
    
    }

    public function delete(Request $request, $id)
    {
        $cart = Cart::findOrFail($id);

        $cart->delete();

        return redirect()->route('cart');
    }

    public function success()
    {
        return view('pages.success');
    }
}

