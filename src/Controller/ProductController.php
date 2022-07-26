<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Product; 
use App\Entity\Category;
use Doctrine\Persistence\ManagerRegistry;
use App\Form\Type\ProductType;

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
    public function add(ManagerRegistry $doctrine, Request $request): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product, [
         'action' => $this->generateUrl('product_add'),
        ]);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()){
            $product = $form->getData();
            dd($product); die;
            $entityManager = $doctrine->getManager();
            $catName = 'computer';
            $category = $entityManager->getRepository(Category::class)->findOneBy(['name'=>$catName]);
            if(!$category){
                $category = new Category();
                $category->setName($catName);
                $entityManager->persist($category);
            }
            
            $product->setCategory($category);

            $entityManager->persist($product);
            $entityManager->flush();

            $this->addFlash('success', 'New product saved with id: '.$product->getId());
            return $this->redirectToRoute('app_product');
        }

        return $this->renderForm('product/new.html.twig', [
            'form' => $form,
        ]);
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
        return $this->render('product/show.html.twig', [
            'product' => $product
        ]);
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

        $this->addFlash('success', 'Product deleted successfully!');
        return $this->redirectToRoute('app_product');
    }
}
