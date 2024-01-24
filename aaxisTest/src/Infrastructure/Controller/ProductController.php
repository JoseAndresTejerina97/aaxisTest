<?php

namespace App\Infrastructure\Controller;

use App\Application\CreateProduct;
use App\Application\ProductLister;
use App\Application\UpdateProduct;
use App\Infrastructure\Service\RequestProduct;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    #[Route('/api/products',name: 'api_login', methods: ['GET'])]
    public function getListProducts(ProductLister $productLister): JsonResponse
    {
        try {
            $results = $productLister->execute();
            $products = [];

            //TO DO: reemplazar por un servicio ProductResponse
            foreach ($results as $result) {
                $product = array();
                $product["name"] = $result->getProductName();
                $product["sku"] = $result->getSku();
                $product["description"] = $result->getDescription();
                $products[] = $product;
            }
            return new JsonResponse($products);
        } catch (Exception $exception) {
            return new JsonResponse($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse($results);
    }
    #[Route('/api/products', methods: ['POST'])]
    public function createProduct(Request $request, CreateProduct $createProduct): JsonResponse
    {
        try {
            $products = $request->toArray();
            $results = $createProduct->execute($products);
            if ($results === true) {
                return new JsonResponse("Ingreso exitoso", Response::HTTP_ACCEPTED);
            } else {
                return new JsonResponse($results, Response::HTTP_BAD_REQUEST);
            }
        } catch (Exception $exception) {
            return new JsonResponse($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse($results);
    }

    #[Route('/api/products', methods: ['PATCH'])]
    public function updateProduct(Request $request, UpdateProduct $updateProduct): JsonResponse
    {
        try {
            $products = $request->toArray();

            $results = $updateProduct->execute($products);
            if ($results) {
                return new JsonResponse("Actualización exitosa", Response::HTTP_ACCEPTED);
            }
        } catch (Exception $exception) {
            return new JsonResponse($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse($results);
    }
}
