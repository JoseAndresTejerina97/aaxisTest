<?php

namespace App\Infrastructure\Persistence\Doctrine;

use App\Domain\Exception\RepositoryException;
use App\Domain\Exception\ValidationException;
use App\Domain\Interface\ProductRepositoryInterface;
use App\Infrastructure\Service\RequestManagerInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ProductRepository extends ServiceEntityRepository implements ProductRepositoryInterface
{
    private $validator;

    public function __construct(ManagerRegistry $registry, ValidatorInterface $validator)
    {
        $this->validator = $validator;
        parent::__construct($registry, Product::class);
    }

    /**
     * @throws RepositoryException
     */
    public function createProduct(array $products): bool|string
    {
        $errorsLabels = "";
        foreach ($products as $product) {
            $productM = new Product();
            $productM->setProductName($product["product_name"]);
            $productM->setSku($product["sku"]);
            $productM->setDescription($product["description"]);
            $this->getEntityManager()->persist($productM);
            $errors = $this->validator->validate($productM);

            if (count($errors) > 0) {
                $errorsLabels = (string) $errors;
                return $errorsLabels;
            }
        }
        try {
            $this->getEntityManager()->flush();
            return true;
        } catch (\Exception $exception) {
            return new RepositoryException($exception->getMessage());
        }
    }

    public function updateProduct(array $products): bool|string
    {
        $errorsLabels = "";
        foreach ($products as $product) {
            $productM = (object)$this->findOneBy(['sku' => $product["sku"]]);
            $productM->setProductName($product["product_name"]);
            $productM->setSku($product["sku"]);
            $productM->setDescription($product["description"]);
            $this->getEntityManager()->persist($productM);
            $errors = $this->validator->validate($productM);

            if (count($errors) > 0) {
                $errorsLabels = (string) $errors;
                return $errorsLabels;
            }
        }
        try {
            $this->getEntityManager()->flush();
            return true;
        } catch (\Exception $exception) {
            new RepositoryException($exception->getMessage());
        }
    }

    public function getProducts(): array
    {

        try {
            $products = $this->findAll();
            return $products;
        } catch (\Exception $exception) {
            throw new RepositoryException($exception->getMessage());
        }
    }

    public function getProductBySku($sku): object|null
    {
        try {
            $product = $this->findOneBy(['sku' => $sku]);
            return $product;
        } catch (\Exception $exception) {
            throw new RepositoryException($exception->getMessage());
        }
    }
}
