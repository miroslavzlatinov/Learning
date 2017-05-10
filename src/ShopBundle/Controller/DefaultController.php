<?php

namespace ShopBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use ShopBundle\Entity\Category;
use ShopBundle\Entity\Product;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="home_index")
     */
    public function indexAction()
    {
        return $this->render('@Shop/Default/index.html.twig');

    }

    /**
     * @Route("backstore", name="store_main")
     * @return \Symfony\Component\HttpFoundation\Response
     */

    public function backstoreAction(Request $request)
    {


        $categories = $this->getDoctrine()
            ->getRepository(Category::class)
            ->findBy([], array('printNum' => 'ASC'));


        $title = 'Category Menu';

        $query = $this->getDoctrine()->getRepository(Product::class)->createQueryBuilder("p");
        $query->where($query->expr()->in('p.published', ':pub'))
            ->setParameter(':pub', 1);


        $inner = '';
        $calculator = $this->get("offer.calculator");
        foreach ($categories as $category) {

            foreach ($category->getProducts() as $product) {
                if ($product->getPublished()) {
                    if ($calculator->calculate($product)) {
                        $inner = $product->setPromotionalPrice($calculator->calculate($product));
                    }


                }
            }

            $products[] = $inner;
        }


        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query->getQuery(),
            $request->query->getInt('page', 1), 4);
//"date('now') >= date('2017-01-20') and date('now') <= date('2018-02-02') ? 0.05 : 0"

        return $this->render('@Shop/Default/store.html.twig',
            ['categories' => $categories, 'pagination' => $pagination,
                'menucategories' => $categories, 'title' => $title]);

    }

    /**
     * @param $id
     * @return Response
     * @Route("backstore/{id}",name="category_one")
     */
    public function categoryAction($id, Request $request)
    {
        $categories = $this->getDoctrine()->getRepository(Category::class)
            ->findBy([], array('printNum' => 'ASC'));

        $query = $this->getDoctrine()->getRepository(Product::class)->createQueryBuilder("p");
        $query->where($query->expr()->in('p.published', ':pub'))->andWhere($query->expr()->in('p.category', ':id'))->setParameter(':id', $id)
            ->setParameter(':pub', 1);

        $a = array_map(function ($in) {
            return [$in->getId() => $in->getName()];
        }, $categories);
        $title = array_column($a, $id)[0];


        $calculator = $this->get("offer.calculator");
        foreach ($categories as $category) {

            foreach ($category->getProducts() as $product) {
                if ($product->getPublished() && $product->getCategory()->getId())
                    if ($calculator->calculate($product)) {
                        $product->setPromotionalPrice($calculator->calculate($product));

                    }
            }
        }
        $paginator = $this->get('knp_paginator');
        $pagination = $paginator->paginate(
            $query->getQuery(),
            $request->query->getInt('page', 1), 6);


        if ($id) {
            $category = $this->getDoctrine()->getRepository(Category::class)
                ->findOneBy(['id' => $id]);


            return $this->render('@Shop/Default/store.html.twig',
                ['categories' => [$category], 'pagination' => $pagination,
                    'menucategories' => $categories,
                    'title' => $title]);
        }


    }

    /**
     * @return Response
     *
     * @Route("manage",name="manage_main")
     *
     */
    public function manageAction()
    {
        return $this->render("@Shop/Default/manage.html.twig");

    }





    /**
     * @param Product $id
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     *
     * @Route("/product/{id}" , name="product_get")
     */

    public function getProductAction(Product $product, Request $request)
    {


        $product = $this->getDoctrine()->getRepository('ShopBundle:Product')->find($product);

        if (!$product) {
            return $this->redirectToRoute('store_main');
        }

        $promo = $this->getDoctrine()->getRepository('ShopBundle:Promotion')->findActivePromotions();
        if (!$promo) {
            return $this->render('@Shop/Product/back_product.html.twig',
                ['product' => $product]);
        }

        $product->setPromotionalPrice($this->get("offer.calculator")->calculate($product));

        return $this->render('@Shop/Product/back_product.html.twig', ['product' => $product]);

    }
}


