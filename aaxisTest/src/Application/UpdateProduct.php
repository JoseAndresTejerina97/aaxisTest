<?php

namespace App\Application;

use App\Domain\Interface\ProductRepositoryInterface;
use App\Domain\Exception\RepositoryException;
use App\Domain\Exception\ServiceException;
use phpDocumentor\Reflection\Types\Boolean;

class UpdateProduct
{
    private ProductRepositoryInterface $productRepository;

    public function __construct(ProductRepositoryInterface $productRepository)
    {
        $this->productRepository = $productRepository;
    }

    /**
     * @throws ServiceException
     */
    public function execute(array $products): bool|string
    {
        try {
            $product = $this->productRepository->updateProduct($products);

            return $product;
        } catch (RepositoryException $exception) {
            throw new ServiceException($exception->getMessage());
        }
    }
}
