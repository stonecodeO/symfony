<?php

namespace App\Controller;


use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Twig\Node\Expression\Binary\AbstractBinary;

class CartController extends AbstractController
{

    /**
     * @Route("/cart", name="cart")
     */
    public function index(SessionInterface $session, ProductRepository $productRepository)
    {
        $panier = $session->get('panier',[]);
        $panierWithData = [];

        foreach ($panier as $id => $quantity){
            $panierWithData[] = [
                'product' => $productRepository->find($id),
                'quantity' => $quantity
            ];
        }
        $total = 0;
        foreach ($panierWithData as $item){
            $totalItem = $item['product']->getPrice()* $item['quantity'];
            $total += $totalItem;
        }
        $totals = $session->get('totals',[]);
        $totals[] = $total;
        return $this->render('cart/index.html.twig', [
            'items' => $panierWithData,
            'total' => $total
        ]);
    }

    /**
     * @Route("/cart/add/{id}", name= "cart_add")
     */
    public function add($id, SessionInterface $session){
        $panier = $session->get('panier',[]);
        $qte = $session->get('qtePanier',0);
        if (!empty($panier[$id])){
            $panier[$id]++;
            $qte++ ;
        }
        else{
            $panier[$id] = 1;
        }

        $session->set('panier', $panier);
        $session->set('qtePanier', $qte);
        return $this->redirectToRoute("product");
    }

    /**
     * @Route("/cart/remove/{id}", name = "cart_remove")
     */
    public function remove($id, SessionInterface $session){
        $panier = $session->get('panier',[]);
        $qte = $session->get('qtePanier', 0);

        if(!empty($panier[$id])){
            unset($panier[$id]);
            $qte--;
        }
        $session->set('panier',$panier);
        $session->set('qtePanier', $qte);

        return $this->redirectToRoute("cart");
    }

}
