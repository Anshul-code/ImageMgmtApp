<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Get All Categories
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAll(): JsonResponse
    {
        $categories = Category::all();

        return response()->json([
            'success' => true,
            'data'    => $categories,
            'message' => __('Log in successfull')
        ]);
    }
}
