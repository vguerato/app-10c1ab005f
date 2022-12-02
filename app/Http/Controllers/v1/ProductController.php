<?php

namespace App\Http\Controllers\v1;

use App\Bindings\Inventory;
use App\Http\Requests\v1\Product\StoreProductRequest;
use App\Http\Requests\v1\Product\UpdateProductRequest;
use App\Http\Resources\v1\ProductChangesResource;
use App\Http\Resources\v1\ProductResource;
use App\Models\Product;
use App\Services\v1\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class ProductController extends Controller
{
    private ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function show(Product $product): ProductResource
    {
        return new ProductResource($product);
    }

    public function list(): AnonymousResourceCollection
    {
        return ProductResource::collection(Product::all());
    }

    public function history(Product $product): AnonymousResourceCollection
    {
        return ProductChangesResource::collection($product->changes);
    }

    public function store(StoreProductRequest $request): JsonResponse
    {
        /** @var Product $product */
        $product = $this->productService->store($request->validated());

        if (!$product) {
            return $this->responseError(500, 'Failed to create Product.');
        }

        return $this->responseSuccess(
            200,
            "Product {$product->name} created",
            new ProductResource($product)
        );
    }

    public function update(
        UpdateProductRequest $request,
        Product $product
    ): JsonResponse
    {
        $product = $this->productService->update(
            $product,
            $request->validated()
        );

        if (!$product) {
            return $this->responseError(500, 'Failed to update Product.');
        }

        return $this->responseSuccess(
            200,
            'Product updated!',
            new ProductResource($product)
        );
    }

    public function inventory(
        Request $request,
        Product $product,
        Inventory $action
    ): JsonResponse
    {
        $request->validate(['quantity' => 'required|integer|min:1']);

        $product = $this->productService->{$action->value}(
            $product,
            $request->get('quantity')
        );

        if (!$product) {
            return $this->responseError(500, 'Failed to change product inventory.');
        }

        return $this->responseSuccess(
            200,
            'Product inventory changed!',
            new ProductResource($product)
        );
    }

    public function delete(Request $request, Product $product): JsonResponse
    {
        if (!$this->productService->delete($product)) {
            return $this->responseError(
                200,
                'Failed to delete Product.'
            );
        }

        return $this->responseSuccess(
            200,
            'Product deleted successfully.'
        );
    }
}
