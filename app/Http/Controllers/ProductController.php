<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\ProductService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;

class ProductController extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
    private $product_service;

    public function __construct(ProductService $productService)
    {
        $this->product_service = $productService;
    }
    public function createProduct(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string'],
            'slug' => ['required', 'string', 'unique:products'],
            'price' => ['required', 'numeric'],
            'special_price' => ['nullable', 'numeric'],
            'special_price_from' => ['nullable', 'date'],
            'special_price_to' => ['nullable', 'date'],
            'is_active' => ['required', 'boolean'],
        ]);

        return $this->product_service->createProduct($request);
    }

    public function updateProduct(Request $request)
    {
        $request->validate([
            'name' => ['string'],
            'slug' => ['string', 'unique:products'],
            'price' => ['numeric'],
            'special_price' => ['nullable', 'numeric'],
            'special_price_from' => ['nullable', 'date'],
            'special_price_to' => ['nullable', 'date'],
            'is_active' => ['boolean'],
        ]);

        return $this->product_service->updateProduct($request);
    }

    public function listProducts(Request $request)
    {

        return $this->product_service->listProducts($request);
    }

    public function getProduct(Request $request)
    {
        return $this->product_service->getProduct($request);
    }

    public function deleteProduct(Request $request)
    {
        return $this->product_service->deleteProduct($request);
    }
}
