<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DetailTransactions extends Model
{
    protected $table = 'detail_transactions';
    protected $fillable = [
        'transaction_id',
        'product_id',
        'jumlah',
    ];

    public function transaction()
    {
        return $this->belongsTo('App\Models\Tansaction');
    }

    public function product()
    {
        return $this->belongsTo('App\Models\Product');
    }
}
