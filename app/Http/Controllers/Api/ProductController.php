<?php

namespace App\Http\Controllers\Api;

use App\Enums\ProductStatusEnum;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ProductIndexRequest;
use App\Http\Resources\ProductCategoryResource;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductController extends Controller
{
    public function index(ProductIndexRequest $request): AnonymousResourceCollection
    {
        $products = Product::with(['category', 'images'])
            ->where('is_active', true)
            ->when($request->filled('category'), fn ($query) => $query->where('product_category_id', $request->input('category')))
            ->when($request->filled('status'), fn ($query) => $query->where('status', $request->input('status')))
            ->when($request->filled('priceFrom'), fn ($query) => $query->where('price', '>=', $request->input('priceFrom')))
            ->when($request->filled('priceTo'), fn ($query) => $query->where('price', '<=', $request->input('priceTo')))
            ->get();

        return ProductResource::collection($products);
    }

    public function show(Product $product): ProductResource
    {
        $product->loadMissing(['category', 'images']);

        return ProductResource::make($product);
    }

    public function getFilters(): JsonResponse
    {
        $categories = ProductCategory::all();
        $statuses = ProductStatusEnum::values();
        $priceRange = Product::selectRaw('MIN(price) as min_price, MAX(price) as max_price')->first();

        return response()->json([
            'categories' => ProductCategoryResource::collection($categories),
            'statuses' => $statuses,
            'priceRange' => $priceRange,
        ]);
    }
}
