<?php

namespace ShopBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use ShopBundle\Entity\Category;
use ShopBundle\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


/**
 * Class CategoryController
 * @package ShopBundle\Controller
 * @Route("manage/",name="data_manage")
 */
class CategoryController extends Controller
{

    /**
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("category/list", name="category_list" )
     */

    public function listCategoriesAction(Request $request)
    {
        $paginator = $this->get('knp_paginator');
        $query = $this->getDoctrine()->getRepository("ShopBundle:Category")
            ->createQueryBuilder("p");
        $query->select('p')->orderBy('p.printNum');
        $pagination = $paginator->paginate(
            $query->getQuery(),
            $request->query->getInt('page', 1), 6);


//        $num = array();
//        foreach ($category as $key => $row) {
//            $num[$key] = $row->getPrintNum();;
//        }
//        array_multisort($num, SORT_ASC, $category);

        try {
            return $this->render('@Shop/Category/list.html.twig', array('pagination' => $pagination));
        } catch (\Exception $e) {
        }
        $this->addFlash('info', "First Create a Category");
        return $this->redirectToRoute('category_add');


    }


    /**
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("category/create", name="category_add")
     * @Method({"GET"})
     */


    public function createCategoryAction()
    {

        $form = $this->createForm(CategoryType::class)
            ->add("create", SubmitType::class, array(
                'attr' => array('class' => 'btn-success')))
            ->add("cancel", SubmitType::class, array(
                'attr' => array('class' => 'btn-primary', 'formnovalidate' => true)));

        return $this->render('@Shop/Category/create.html.twig',
            ['categoryForm' => $form->createView()]);

    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @param $id
     * @Route("category/create", name="category_add_process")
     * @Method({"POST"})
     */
    public function addCategoryProccessActon(Request $request)

    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category)
            ->add("create", SubmitType::class, array(
                'attr' => array('class' => 'btn-success')))
            ->add("cancel", SubmitType::class, array(
                'attr' => array('class' => 'btn-primary', 'formnovalidate' => true)
            ));
        $form->handleRequest($request);
        if ($form->get('cancel')->isClicked()) {
            return $this->redirectToRoute('category_list');
        }

        if ($form->isSubmitted() && $form->isValid()) {

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($category);
            $entityManager->flush();

            $this->addFlash("info", "Category with name " . $category->getName() . " was added successfully");


            return $this->redirectToRoute('category_list');


        }


        return $this->render('@Shop/Category/create.html.twig',
            ['categoryForm' => $form->createView()]);


    }

    /**
     *
     * @Route("category/edit/{id}", name="category_edit")
     * @Method("GET")
     *
     * @param Category $category
     * @return Response
     */

    public function editCategoryAction(Category $category)
    {
        $form = $this->createForm(CategoryType::class, $category)
            ->add("edit", SubmitType::class, array(
                'attr' => array('class' => 'btn-warning')))
            ->add("cancel", SubmitType::class, array(
                'attr' => array('class' => 'btn-primary', 'formnovalidate' => true)));

        return $this->render('@Shop/Category/edit.html.twig', ['editForm' => $form->createView()]);

    }

    /**
     * @param Category $category
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     *
     * @Method("POST")
     * @Route("category/edit/{id}", name="category_edit_process")
     */

    public function editCategoryProcessAction(Category $category, Request $request)

    {
        $form = $this->createForm(CategoryType::class, $category)
            ->add("edit", SubmitType::class, array(
                'attr' => array('class' => 'btn-warning')))
            ->add("cancel", SubmitType::class, array(
                'attr' => array('class' => 'btn-primary', 'name' => 'cancel', 'formnovalidate' => true)));

        $form->handleRequest($request);


        if ($form->get('cancel')->isClicked()) {
            return $this->redirectToRoute('category_list');
        }
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($category);
            $entityManager->flush();
            $this->addFlash("info", "Category with name " . $category->getName() . " was edited successfully");

            return $this->redirectToRoute('category_list');

        }


        return $this->render('@Shop/Category/edit.html.twig', ['editForm' => $form->createView()]);
    }

    /**
     * @param Category $category
     * @Method({"POST"})
     *
     * @Route("category/delete/{id}", name="category_delete")
     */
    public function deleteCategoryAction(Category $category)
    {

        try {
            $manager = $this->getDoctrine()->getManager();

            $manager->remove($category);
            $manager->flush();
        } catch (\Exception $e) {
            $this->addFlash("error", 'can not delete Category countains products');
            return $this->redirectToRoute("category_list");
        }
        $this->addFlash("delete", "Category deleted!!!");
        return $this->redirectToRoute("category_list");


    }
}
