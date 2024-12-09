<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;

class CategoryProductController extends Controller
{
    public function index($id)
    {
        $category = Category::with('products.stocks')
            ->where('id', $id)
            ->first();

        $products = $category->products()->paginate(10);
        if (!$category || !$products) {
            return $this->error('Not found', 404);
        }
        return $this->responsePagination($products, new CategoryResource($category->load('products')));
    }

}
