<?php

namespace App\Controller;

use App\Entity\Product;
use App\Entity\ProductSearch;
use App\Entity\Search;
use App\Form\SearchType;
use App\Repository\ProductRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @Route("/", name="product")
   */
    public function index(PaginatorInterface $paginator,ProductRepository $repository,Request $request)
    {
        $search = new Search();
        $form = $this->createForm(SearchType::class,$search);
        $form->handleRequest($request);
        [$min,$max] =$repository->findMinMax($search);
        $products = $paginator->paginate(
            $repository->findAllVisibleQuery($search),
            $request->query->getInt('page', 1),
            15
        );
        if ($request->get('ajax')){
            return new JsonResponse([
                'content' => $this->renderView('product/_product.html.twig',['products' => $products]),
                'sorting' => $this->renderView('product/_sorting.html.twig',['products' => $products]),
                'pagination' => $this->renderView('product/_pagination.html.twig',['products' => $products]),
                'pages' => ceil($products->getTotalItemCount() / $products->getItemNumberPerPage()),

            ]);
        }
        return $this->render('product/index.html.twig', [
            'products' => $products,
            'form' => $form->createView(),
            'min' => $min,
            'max' => $max
        ]);
    }
    /**
     * @Route("/product/show/{id}", name="product_show")
     */
    public function show(ProductRepository $repository,Product $product){
        return $this->render('product/show.html.twig',[
            'product' => $product
        ]);
    }
}
