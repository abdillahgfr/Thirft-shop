<?php

namespace App;

use App\Helpers\Recommend;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravelista\Comments\Commenter;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable, Commenter;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'roles', 'store_name', 'categories_id', 'store_status',
        'address_one', 'address_two', 'provinces_id', 'regencies_id', 'zip_code', 'country', 'phone_number', 'photos', 'nama_rekening', 'no_rekening', 'product_status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function rates()
    {
        return $this->hasManyThrough(ProductReview::class, Product::class, 'users_id');
    }

    public function getAverageRateAttribute()
    {
        return $this->rates()->avg('rate');
    }

    public function reviews()
    {
        return $this->hasMany(ProductReview::class);
    }

    public function getRecommendedProductAttribute()
    {
        // bikin helper class baru 
        $recommend = new Recommend();

        // mengambil semua review dari semua user
        $all = User::with('reviews.product')->get()->mapWithKeys(function ($user, $index) {
            // mengambil semua review dari satu user
            $reviews = $user->reviews->mapWithKeys(function ($review) {
                return [
                    $review->product->slug => $review->rate
                ];
            });

            return [
                $user->email => $reviews->toArray()
            ];
        });

        return collect($recommend->getRecommendations($all, $this->email))->keys()->map(function ($product_slug) {
            return Product::where('slug', $product_slug)->first();
        });
    }
}
