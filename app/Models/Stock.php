<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    protected $table = 'branch_stocks';
    protected $fillable = [
        'branch_id',
        'product_id',
        'stok',
    ];

    public function branch()
    {
        return $this->belongsTo('App\Models\Branch');
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }
}
