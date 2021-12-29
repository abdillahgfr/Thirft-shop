<?php

namespace App\Http\Controllers;

use App\User;

use App\Comment;
use App\Product;
use App\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{

	/**
	 * Show the application dashboard.
	 *
	 * @return \Illuminate\Contracts\Support\Renderable
	 */
	public function index()
	{
		$user = Auth::user();
		$categories = Category::take(6)->get();
		$products = Product::with(['galleries'])->take(8)->latest()->get();
		$rekomendasi = Product::with(['galleries'])->take(4)->inRandomOrder()->get();
		$array_rekomendasi = array();
		$array_push_rekomendasi = array();

		//Tambahan Syntax Untuk Rekomendasi
		// $categories_id="";
		// if(!Auth::guest())
		// {
		// 	$categories_count=DB::select("SELECT b.categories_id,COUNT(b.categories_id) AS record_count FROM record a JOIN products b ON b.id=a.product_id where a.id='".Auth::user()->id."' GROUP BY b.categories_id having COUNT(b.categories_id)>=3 ORDER BY COUNT(b.categories_id) desc");
		// 	if(count($categories_count)>0)
		// 	{
		// 		foreach($categories_count as $c)
		// 		{
		// 			$categories_id=$categories_id.$c->categories_id.",";
		// 		}
		// 		$categories_id=rtrim($categories_id, ", ");
		// 		$rekomendasi_=DB::select("select a.*,b.photos,c.record_count from products a join product_galleries b on b.products_id=a.id join(SELECT b.categories_id,COUNT(b.categories_id) AS record_count FROM record a JOIN products b ON b.id=a.product_id GROUP BY b.categories_id ORDER BY COUNT(b.categories_id) desc) c on c.categories_id=a.categories_id where a.categories_id in ($categories_id) order by c.record_count desc");
		// 		$categories_count_=DB::select("SELECT b.categories_id,COUNT(b.categories_id) AS record_count FROM record a JOIN products b ON b.id=a.product_id where a.id='".Auth::user()->id."' GROUP BY b.categories_id having COUNT(b.categories_id)>=3 ORDER BY COUNT(b.categories_id) desc limit 4");
		// 		foreach($categories_count_ as $c)
		// 		{
		// 			$index=1;
		// 			foreach($rekomendasi_ as $r)
		// 			{
		// 				if($index<5 && $r->categories_id==$c->categories_id)
		// 				{
		// 					$array_rekomendasi["name"]=$r->name;
		// 					$array_rekomendasi["price"]=$r->price;
		// 					$array_rekomendasi["photos"]=$r->photos;
		// 					$array_rekomendasi["slug"]=$r->slug;
		// 					array_push($array_push_rekomendasi,$array_rekomendasi);
		// 					$index=$index+1;
		// 				}
		// 			}
		// 		}
		// 	}
		// 	else
		// 	{
		// 		$rekomendasi_=DB::select("select a.*,b.photos from products a join product_galleries b on b.products_id=a.id ORDER BY RAND() limit 12");
		// 		foreach($rekomendasi_ as $r)
		// 		{	
		// 			$array_rekomendasi["name"]=$r->name;
		// 			$array_rekomendasi["price"]=$r->price;
		// 			$array_rekomendasi["photos"]=$r->photos;
		// 			$array_rekomendasi["slug"]=$r->slug;
		// 			array_push($array_push_rekomendasi,$array_rekomendasi);
		// 		}
		// 	}
		// }
		// else
		// {
		// 	$rekomendasi_=DB::select("select a.*,b.photos from products a join product_galleries b on b.products_id=a.id ORDER BY RAND() limit 12");
		// 	foreach($rekomendasi_ as $r)
		// 	{		
		// 		$array_rekomendasi["name"]=$r->name;
		// 		$array_rekomendasi["price"]=$r->price;
		// 		$array_rekomendasi["photos"]=$r->photos;
		// 		$array_rekomendasi["slug"]=$r->slug;
		// 		array_push($array_push_rekomendasi,$array_rekomendasi);
		// 	}
		// }

		// pengecekan udah login atau belum
		if (!Auth::guest()) {

			// bila sudah login perhitungan collaborative filter
			$array_push_rekomendasi = Auth::user()->recommended_product;
		}


		//End
		$comments = Comment::with(['product', 'user'])->whereHas('product', function ($product) {
			$product->where('users_id');
		})->get();
		return view('pages.home', [
			'user' => $user,
			'categories' => $categories,
			'products' => $products,
			'rekomendasi' => $rekomendasi,
			'array_push_rekomendasi' => $array_push_rekomendasi,
			'comments' => $comments
		]);
	}
}
