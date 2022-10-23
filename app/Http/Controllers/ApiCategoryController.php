<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class ApiCategoryController extends Controller
{
    public function showAllCategory(): JsonResponse
    {
        return response()->json(Category::all());
    }

    public function showMainCategory(): JsonResponse
    {
        $sql = Category::where('parent_id', 0)->get();
        return response()->json($sql);
    }

    public function showSubCategory($id): JsonResponse
    {
        $sql = Category::where('parent_id', $id)->get();
        return response()->json($sql);
    }
}
