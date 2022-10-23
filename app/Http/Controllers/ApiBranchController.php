<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Http\JsonResponse;

class ApiBranchController extends Controller
{
    public function showAllBranch(): JsonResponse
    {
        $sql = Branch::orderBy('nama', 'ASC')->get();
        return response()->json($sql);
    }

    public function showProductbyBranch($id): JsonResponse
    {
        $sql = Stock::join('branches', 'branches.id', 'branch_stocks.branch_id')
            ->join('products', 'products.id', 'branch_stocks.product_id')->where('branches.id', $id)
            ->get();
        return response()->json($sql);
    }
}
