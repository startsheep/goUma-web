<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

class ApiProductController extends Controller
{
    public function showAllProduct(): JsonResponse
    {
        $sql = Product::with(['partner', 'categoryProducts.category'])->get();
        return response()->json($sql);
    }

    public function showOneProduct($id): JsonResponse
    {
        $sql = Product::where('id', $id)->with(['partner', 'categoryProducts.category'])->get();
        return response()->json($sql);
    }

    public function showProductbyCategory($id): JsonResponse
    {
        $sql = Product::with(['partner', 'categoryProducts.category'])
            ->join('product_categories', 'product_categories.product_id', '=', 'products.id')
            ->where('product_categories.category_id', '=', $id)
            ->get();
        return response()->json($sql);
    }
}
