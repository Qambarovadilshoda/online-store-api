<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Http\Resources\ProductResource;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{

    public function index()
    {
        $products = Product::with('stocks')->paginate(25);
        return $this->responsePagination($products, ProductResource::collection($products));
    }

    public function store(StoreProductRequest $request)
    {
        $category = Category::find($request->category_id);
        if(!$category){
            return $this->error('Category not found', 404);
        }
        $product = $category->products()->create([
            'category_id' => $category->id,
            'name' => $request->name,
            'description' => $request->description
        ]);
        return $this->success($product, 'Product Created', 201);
    }

    public function show($id)
    {
        $product = Product::with('stocks', 'category')->find($id);
        if(!$product){
            return $this->error('Product not found', 404);
        }
        return $this->success(new ProductResource($product));
    }

    public function update(UpdateProductRequest $request, Product $product)
    {

    }

    public function destroy(Product $product)
    {

    }
}
