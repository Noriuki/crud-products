<?php

namespace App\Services;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductService
{
  public function createProduct(Request $request)
  {
    $product = Product::create($request->all());

    return $product;
  }

  public function updateProduct(Request $request)
  {

    $product = Product::where('id', $request->id)->first();

    if (!$product) {
      return response()->json([], 404);
    }

    $product->update($request->all());

    return $product;
  }

  public function listProducts(Request $request)
  {
    $product_list = Product::where('is_active', 1)->with('categories')->get();

    return $product_list;
  }

  public function getProduct(Request $request)
  {

    $product = Product::where('slug', $request['slug'])->with('categories')->first();
    if (!$product) {
      return response()->json([], 404);
    }
    return $product;
  }

  public function deleteProduct(Request $request)
  {
    $product = Product::where('id', $request['id'])->first();
    if (!$product) {
      return response()->json([], 404);
    }
    $product->delete();
    return response()->json([], 200);
  }
}
