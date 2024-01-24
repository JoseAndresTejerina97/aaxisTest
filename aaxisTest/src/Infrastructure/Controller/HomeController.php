<?php

namespace App\Infrastructure\Controller;

use App\Application\ProductBySku;
use App\Application\ProductLister;
use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    #[Route('/')]
    public function getListProducts(ProductLister $productLister): Response
    {
        try {
            $results = $productLister->execute();
        } catch (Exception $exception) {
            return new JsonResponse($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }

        return $this->render("product/index.html.twig");
    }
    #[Route('/product/create')]
    public function getCreateProduct(ProductLister $productLister): Response
    {
        try {
            $results = $productLister->execute();
        } catch (Exception $exception) {
            return new JsonResponse($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }

        return $this->render("product/createProduct.html.twig");
    }

    #[Route('/product/update/{sku}')]
    public function getUpdateProduct($sku, ProductBySku $getProductBySku): Response
    {
        try {
            $product = $getProductBySku->execute($sku);
        } catch (Exception $exception) {
            return new JsonResponse($exception->getMessage(), Response::HTTP_BAD_REQUEST);
        }

        return $this->render("product/updateProduct.html.twig", ["product" => $product]);
    }
}
