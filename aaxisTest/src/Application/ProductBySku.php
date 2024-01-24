<?php

namespace App\Application;

use App\Domain\Exception\RepositoryException;
use App\Domain\Exception\ServiceException;
use App\Domain\Interface\ProductRepositoryInterface;

class ProductBySku
{
    private ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @throws ServiceException
     */
    public function execute($id): object|null
    {
        try {
            $product = $this->productRepository->getProductBySku($id);
            return $product;
        } catch (RepositoryException $exception) {
            throw new ServiceException($exception->getMessage());
        }
    }
}
