<?php

namespace ShopBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use ShopBundle\Entity\Product;
use ShopBundle\Form\ProductType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ProductController
 * @package ShopBundle\Controller
 *
 * @Route("manage/",name="data_manage")
 */
class ProductController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }


    /**
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("product/list", name="product_list" )
     */

    public function listProductsAction(Request $request)
    {
//        $product = $this->getDoctrine()->getRepository("ShopBundle:Product")->findAll();
        $paginator = $this->get('knp_paginator');
        $query = $this->getDoctrine()->getRepository("ShopBundle:Product")->createQueryBuilder("p");
        $query->select('p');

        $pagination = $paginator->paginate(
            $query->getQuery(),
            $request->query->getInt('page', 1), 6);


        try {
            return $this->render('@Shop/Product/list.html.twig', array('pagination' => $pagination));
        } catch (\Exception $e) {
            dump($e);
            exit;
        }

        $this->addFlash('info', "First Create  Product");
        return $this->redirectToRoute('product_add');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("product/create", name="product_add")
     * @Method({"GET"})
     */


    public function createProductsAction()
    {

        $form = $this->createForm(ProductType::class)

            ->add("create", SubmitType::class, array(
                'attr' => array('class' => 'btn-success', 'formnovalidate' => true)))
            ->add("cancel", SubmitType::class, array(
                'attr' => array('class' => 'btn-primary', 'formnovalidate' => true)));

        return $this->render('@Shop/Product/create.html.twig',
            ['productForm' => $form->createView()]);

    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @param $id
     * @Route("product/create", name="product_add_process")
     * @Method({"POST"})
     */
    public function addProductProccessActon(Request $request)

    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product)
            ->add("create", SubmitType::class, array(
                'attr' => array('class' => 'btn-success', 'formnovalidate' => true)))
            ->add("cancel", SubmitType::class, array(
                    'attr' => array('class' => 'btn-primary', 'formnovalidate' => true))
            );
        $form->handleRequest($request);
        if ($form->get('cancel')->isClicked()) {
            return $this->redirectToRoute('product_list');
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $product->setUser($this->getUser());
            /** @var UploadedFile $file */
            $file = $form['image_form']->getData();
            $extension = $file->guessExtension();
            if (!$extension) {
                // extension cannot be guessed
                $extension = 'bin';
            }

            if (!$file) {
                $form->get('image_form')->addError(new FormError('Image is required'));
            } else {
                $filename = md5($product->getName() . '' . bin2hex(random_bytes(20)));

                $filelocal = $file->move(
                    $this->get('kernel')->getRootDir() . '/../web/images/myshop/',
                    $filename . "." . $extension

                );

                $product->setImage('/images/myshop/' . $filelocal->getFilename());
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($product);
            $entityManager->flush();

            $this->addFlash("info", "Product with name " . $product->getName() . " was added successfully");


            return $this->redirectToRoute('product_list');


        }


        return $this->render('@Shop/Product/create.html.twig',
            ['productForm' => $form->createView()]);


    }

    /**
     *
     * @Route("product/edit/{id}", name="product_edit")
     * @Method({"GET"})
     *
     * @param Product $product
     * @return Response
     */

    public function editProductAction(Product $product)
    {
        $form = $this->createForm(ProductType::class, $product)
            ->add("edit", SubmitType::class, array(
                'attr' => array('class' => 'btn-warning', 'formnovalidate' => true)))
            ->add("cancel", SubmitType::class, array(
                'attr' => array('class' => 'btn-primary', 'formnovalidate' => true)));

        return $this->render('@Shop/Product/edit.html.twig', ['editForm' => $form->createView()]);

    }

    /**
     * @param Product $product
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     *
     * @Method({"POST"})
     * @Route("product/edit/{id}", name="product_edit_process")
     */

    public function editProductProcessAction(Product $product, Request $request)

    {
        $form = $this->createForm(ProductType::class, $product)
            ->add("edit", SubmitType::class, array(
                'attr' => array('class' => 'btn-warning')))
            ->add("cancel", SubmitType::class, array(
                'attr' => array('class' => 'btn-primary', 'name' => 'cancel', 'formnovalidate' => true)));

        $form->handleRequest($request);


        if ($form->get('cancel')->isClicked()) {
            return $this->redirectToRoute('product_list');
        }
        if ($form->isSubmitted() && $form->isValid()) {
            if ($product->getImageForm() instanceof UploadedFile) {

                /** @var UploadedFile $file */
                $file = $form['image_form']->getData();
                $extension = $file->guessExtension();
                if (!$extension) {
                    // extension cannot be guessed
                    $extension = 'bin';
                }

                if (!$file) {
                    $form->get('image_form')->addError(new FormError('Image is required'));
                } else {
                    $filename = md5($product->getName() . '' . bin2hex(random_bytes(20)));

                    $filelocal = $file->move(
                        $this->get('kernel')->getRootDir() . '/../web/images/myshop/',
                        $filename . "." . $extension

                    );

                    $product->setImage('/images/myshop/' . $filelocal->getFilename());
                }
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($product);
            $entityManager->flush();
            $this->addFlash("info", "Product with name " . $product->getName() . " was edited successfully");

            return $this->redirectToRoute('product_list');

        }


        return $this->render('@Shop/Product/edit.html.twig', ['editForm' => $form->createView()]);
    }

    /**
     * @param Product $product
     * @Method({"POST"})
     *
     * @Route("product/delete/{id}", name="product_delete")
     */
    public function deleteProductAction(Product $product)
    {

        try {
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($product);
            $manager->flush();


        } catch (\Exception $e) {
            $this->addFlash("error", 'Cant delete product you have orders or promotion');
            return $this->redirectToRoute("product_list");
        }
        $this->addFlash("delete", "ProductType deleted!!!");
        return $this->redirectToRoute("product_list");

    }


}
