<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;
use App\Entity\Product;

final class ProductController extends AbstractController{
    private string $API_KEY;

    public function __construct()
    {
        $this->API_KEY = $_ENV['API_KEY'] ?? 'DefaultAPIKey'; // Fallback if not set
    }

    #[Route('/', methods: ['GET'])]
    public function index(): JsonResponse
    {
        return new JsonResponse(['message' => 'Welcome to the Product API']);
    }

    #[Route('/api/products/{id}', methods: ['GET'])]
    public function getProduct(int $id, Request $request): JsonResponse
    {
        // We can use this to check for an API key in the request headers to check if the request is authorized
        // if ($request->headers->get('X-API-KEY') !== $this->API_KEY) {
        //     return new JsonResponse(['error' => 'Unauthorized'], 401);
        // }
        
        $products = [
            1 => new Product(1, 'Laptop', 1200.00),
            2 => new Product(2, 'Mouse', 25.00),
            3 => new Product(3, 'Keyboard', 40.00),
        ];

        if (!isset($products[$id])) {
            return new JsonResponse(['message' => 'Product not found'], 404);
        }

        return new JsonResponse([
            'id' => $products[$id]->getId(),
            'name' => $products[$id]->getName(),
            'price' => $products[$id]->getPrice(),
        ]);
    }
}
