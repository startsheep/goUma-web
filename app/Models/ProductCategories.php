<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductCategories extends Model
{
    use HasFactory;

    protected $table = 'product_categories';
    protected $fillable = ['product_id', 'category_id'];

    public function product(){
        return $this->BelongsTo('App\Models\Product');
    }
    public function category(){
        return $this->BelongsTo('App\Models\Category');
    }
}
