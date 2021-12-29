<?php

namespace App\Http\Controllers;

use App\Record;
use App\Comment;
use App\Product;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class CategoryController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {

        $categories = Category::all();
        $products = Product::with(['galleries'])->simplePaginate(8);
        $comments = Comment::with(['product','user'])->whereHas('product', function($product){
                            $product->where('users_id');
                            })->get();
    
        return view('pages.category',[
            'categories' => $categories,
            'products' => $products,
            'comments' => $comments
        ]);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function detail(Request $request, $slug)
    {

        $categories = Category::all();
        $category = Category::where('slug', $slug)->firstOrFail();
        $products = Product::with(['galleries'])->where('categories_id', $category->id)->paginate(10);
        $comments = Comment::with(['product','user'])->whereHas('product', function($product){
                            $product->where('users_id');
                            })->get();

        return view('pages.category',[
            'categories' => $categories,
            'products' => $products,
            'comments' => $comments
        ]);

        
    }

    
    public function cari(Request $request){
        $name = $request->name;
        $categories = Category::all();
        $products = Product::where('name','like',"%".$name."%")->paginate(4);
        $comments = Comment::with(['product','user'])->whereHas('product', function($product){
                            $product->where('users_id');
                            })->get();
		
		//Tambahan Syntax Untuk Rekomendasi
		if(!Auth::guest())
		{
			if($name!=null)
			{
				$product_search=DB::select("select * from products where name like '%$name%'");
				foreach($product_search as $p)
				{
					$data = [
						"id"=>Auth::user()->id,
						"product_id"=>$p->id,            
					];
					Record::create($data);
				}
			}
		}
		//End
		
        return view('pages.category', [
            'categories' => $categories,
            'products' => $products,
            'comments' => $comments
            
        ]);
    }

    
}
