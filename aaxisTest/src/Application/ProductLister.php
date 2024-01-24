<?php

namespace App\Application;

use App\Domain\Exception\RepositoryException;
use App\Domain\Exception\ServiceException;
use App\Domain\Interface\ProductRepositoryInterface;

class ProductLister
{
    private ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @throws ServiceException
     */
    public function execute(): array
    {
        try {
            $products = $this->productRepository->getProducts();
            return $products;
        } catch (RepositoryException $exception) {
            throw new ServiceException($exception->getMessage());
        }
    }
}
