<?php

namespace ShopBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use ShopBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class CartController extends Controller
{


    /**
     * @Route("/cart" , name="cart_index")
     */


    public function indexAction(Request $request)
    {
        // $this->get('basket')->setcookie($request->cookies->get('boiler'));
        $this->get('basket')->refresh();


        return $this->render('@Shop/cart/back.html.twig');


    }

    /**
     *
     *
     * @Route("/cart/add/{id}/{quantity}", name="cart_add")
     */
    public function addAction(Product $product, $quantity, Request $request)
    {
        //  $this->get('basket')->setcookie($request->cookies->get('boiler'));
        $product = $this->getDoctrine()->getRepository('ShopBundle:Product')->findOneBy(['id' => $product]);
        if (!$product) {
            return $this->redirectToRoute('store_main');

        }
        try {

            $this->get('basket')->add($product, $quantity);

        } catch (\Exception $exception) {

            return $this->render('@Shop/cart/back.html.twig', ['exception' => $exception->getMessage(), "productwas" => $product->getId()]);
        }
        return $this->redirectToRoute('cart_index');
    }

    /**
     * @param $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     *
     * @Route("/cart/update/{id}", name="cart_update")
     */

    public function updateAction(Product $product, Request $request)
    {


        // $this->get('basket')->setcookie($request->cookies->get('boiler'));
        $products = $this->getDoctrine()->getRepository('ShopBundle:Product')->findOneBy(['id' => $product]);
        if (!$product) {
            return $this->redirectToRoute('store_main');

        }
        try {

            $this->get('basket')->update($products, $request->get('quantity'));

        } catch (\Exception $exception) {

            return $this->render('@Shop/cart/index.html.twig', ['exception' => $exception->getMessage(), "productwas" => $product->getId()]);
        }
        return $this->redirectToRoute('cart_index');

    }


}
