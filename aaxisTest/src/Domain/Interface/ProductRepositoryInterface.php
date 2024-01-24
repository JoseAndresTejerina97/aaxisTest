<?php

namespace App\Domain\Interface;

use App\Domain\Exception\RepositoryException;

interface ProductRepositoryInterface
{
    /**
     * @throws RepositoryException
     */
    public function createProduct(array $products): bool|string;

    public function updateProduct(array $products): bool|string;

    public function getProducts(): array;

    public function getProductBySku($sku): object|null;
}
