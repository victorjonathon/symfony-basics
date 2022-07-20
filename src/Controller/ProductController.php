<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Product; 
use App\Entity\Category;
use Doctrine\Persistence\ManagerRegistry;

class ProductController extends AbstractController
{
    /**
     * @Route("/product", name="app_product")
     */
    public function index(ManagerRegistry $doctrine): Response
    {
        $repository = $doctrine->getRepository(Product::class);
        $products = $repository->findAll();
        
        if(!$products){
            throw $this->createNotFoundException(
                'No product found for id: '.$id
            );
        }
        return $this->render('product/index.html.twig', [
            'products' => $products
        ]);
    }

    /**
     * @Route("/product/add", name="product_add")
     */
    public function add(ManagerRegistry $doctrine): Response
    {
        $entityManager = $doctrine->getManager();
        $catId = 5;
        $category = $entityManager->getRepository(Category::class)->find($catId);
        
        //$category = new Category();
        //$category->setName('computer');
        //$entityManager->persist($category);

        $product = new Product();
        $product->setName('RAM');
        $product->setPrice(2500);
        $product->setDescription('DDR 3 compact size RAM 4GB');
        
        $product->setCategory($category);

        
        $entityManager->persist($product);
        $entityManager->flush();

        return new Response('New product saved with id: '.$product->getId());
    }

    /**
     * @Route("/product/{id}", name="product_show")
     */
    public function show(ManagerRegistry $doctrine, int $id): Response
    {
        $repository = $doctrine->getRepository(Product::class);
        $product = $repository->find($id);
        
        if(!$product){
            throw $this->createNotFoundException(
                'No product found for id: '.$id
            );
        }
        return new Response('The product is: '.$product->getName());
    }

    /**
     * @Route("/product/delete/{id}", name="product_delete")
     */
    public function remove(ManagerRegistry $doctrine, int $id): Response
    {
        $entityManager = $doctrine->getManager();
        $product = $entityManager->getRepository(Product::class)->find($id);

        if (!$product) {
            throw $this->createNotFoundException(
                'No product found for id '.$id
            );
        }

        $entityManager->remove($product);
        $entityManager->flush();

        return new Response('Product deleted successfully!');
    }
}
