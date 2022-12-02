<?php

namespace App\Services\v1;

use App\Models\Product;
use App\Repository\v1\ProductRepository;
use Exception;
use Illuminate\Database\Eloquent\Model;

class ProductService
{
    private ProductRepository $productRepository;

    public function __construct(ProductRepository $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    public function store(array $data): ?Model
    {
        return $this->productRepository->create($data);
    }

    public function update(Product $product, array $data): ?Model
    {
        return $this->productRepository->update($product->id, $data);
    }

    public function increment(Product $product, $quantity): ?Model
    {
        return $this->update($product, [
            'quantity' => $quantity + $product->quantity
        ]);
    }

    /**
     * @throws Exception
     */
    public function reduce(Product $product, $quantity): ?Model
    {
        if (($product->quantity - $quantity) < 0) {
            throw new Exception('Product inventory cannot be negative!');
        }

        return $this->update($product, [
            'quantity' => $product->quantity - $quantity
        ]);
    }

    public function delete(Product $product): bool
    {
        return $this->productRepository->delete($product->id);
    }
}
