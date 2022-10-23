<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Keranjang extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'user_id', 'jumlah'];

    public function user()
    {
        return $this->hasOne('App\User');
    }

    public function product()
    {
        return $this->hasMany('App\Models\Product');
    }
}
