<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = [
        'id', 'commenter_id', 'commenter_type', 'guest_name', 'guest_email', 'comment', 'commentable_type', 'commentable_id', 'approved', 'child_id', 'created_at' 
    ];

    protected $hidden = [
        
    ];
    
    public $timestamps = false;

    public function product() {
        return $this->hasOne(Product::class, 'id', 'commentable_id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'commenter_id', 'id');
    }
}

