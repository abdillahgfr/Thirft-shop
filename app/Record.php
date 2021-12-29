<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Record extends Model
{
	protected $table = 'record';
	
    protected $fillable = [
        'id', 'product_id', 'created_date'
    ];

    protected $hidden = [
        
    ];
}
