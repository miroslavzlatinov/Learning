<?php

namespace ShopBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use ShopBundle\Entity\Promotion;
use ShopBundle\Form\CategoryPromotionType;
use ShopBundle\Form\ProductPromotionType;
use ShopBundle\Form\UserPromotionType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


/**
 * Class PromotionController
 * @package ShopBundle\Controller
 *
 * @Route("manage/",name="data_manage")
 */
class PromotionController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('', array('name' => $name));
    }

    /**
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("promotion/list/category", name="promotion_list_c" )
     */

    public function listCategoryPromotionsAction(Request $request)
    {
        $paginator = $this->get('knp_paginator');
        $query = $this->getDoctrine()->getRepository("ShopBundle:Promotion")
            ->findCategoryPromotions();
        $pagination = $paginator->paginate(
            $query->getQuery(),
            $request->query->getInt('page', 1), 6);
        try {
            return $this->render('@Shop/Promotion/categorylist.html.twig', array('pagination' => $pagination));
        } catch (\Exception $e) {


        }

        $this->addFlash('info', "First Create  Promotion");
        return $this->redirectToRoute('promotion_add_c');
    }

    /**
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("promotion/list/product", name="promotion_list_p" )
     */

    public function listProductPromotionsAction(Request $request)
    {
        $paginator = $this->get('knp_paginator');
        $query = $this->getDoctrine()->getRepository("ShopBundle:Promotion")
            ->findProductPromotions();
        $pagination = $paginator->paginate(
            $query->getQuery(),
            $request->query->getInt('page', 1), 6);
        try {
            return $this->render('@Shop/Promotion/productlist.html.twig', array('pagination' => $pagination));
        } catch (\Exception $e) {


        }

        $this->addFlash('info', "First Create  Promotion");
        return $this->redirectToRoute('promotion_add_p');
    }

    /**
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("promotion/list/user", name="promotion_list_u" )
     */

    public function listUserPromotionsAction(Request $request)
    {
        $paginator = $this->get('knp_paginator');
        $query = $this->getDoctrine()->getRepository("ShopBundle:Promotion")
            ->findUserPromotion();
        $pagination = $paginator->paginate(
            $query->getQuery(),
            $request->query->getInt('page', 1), 6);
        try {
            return $this->render('@Shop/Promotion/userlist.htm.twig', array('pagination' => $pagination));
        } catch (\Exception $e) {


        }

        $this->addFlash('info', "First Create  Promotion");
        return $this->redirectToRoute('promotion_add_u');
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("promotion/create/category", name="promotion_add_c")
     * @Method({"GET"})
     */


    public function createCategoryPromotionsAction()
    {

        $form = $this->createForm(CategoryPromotionType::class);
        $form->add("create", SubmitType::class, array(
            'attr' => array('class' => 'btn-success', 'formnovalidate' => true)))
            ->add("cancel", SubmitType::class, array(
                'attr' => array('class' => 'btn-primary', 'formnovalidate' => true)));

        return $this->render('@Shop/Promotion/create.html.twig',
            ['promotionForm' => $form->createView()]);

    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("promotion/create/product", name="promotion_add_p")
     * @Method({"GET"})
     */


    public function createProductPromotionsAction()
    {

        $form = $this->createForm(ProductPromotionType::class);
        $form->add("create", SubmitType::class, array(
            'attr' => array('class' => 'btn-success', 'formnovalidate' => true)))
            ->add("cancel", SubmitType::class, array(
                'attr' => array('class' => 'btn-primary', 'formnovalidate' => true)));

        return $this->render('@Shop/Promotion/create.html.twig',
            ['promotionForm' => $form->createView()]);

    }


    /**
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("promotion/create/user", name="promotion_add_u")
     * @Method({"GET"})
     */


    public function createUserPromotionsAction()
    {

        $form = $this->createForm(UserPromotionType::class);
        $form->add("create", SubmitType::class, array(
            'attr' => array('class' => 'btn-success', 'formnovalidate' => true)))
            ->add("cancel", SubmitType::class, array(
                'attr' => array('class' => 'btn-primary', 'formnovalidate' => true)));

        return $this->render('@Shop/Promotion/usercreate.html.twig',
            ['promotionForm' => $form->createView()]);

    }


    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @param $id
     * @Route("promotion/create/category", name="promotion_add_process_c")
     * @Method({"POST"})
     */
    public function addPromotionProccessActon(Request $request)

    {
        $Promotion = new Promotion();
        $form = $this->createForm(CategoryPromotionType::class, $Promotion)
            ->add("create", SubmitType::class, array(
                'attr' => array('class' => 'btn-success', 'formnovalidate' => true)))
            ->add("cancel", SubmitType::class, array(
                    'attr' => array('class' => 'btn-primary', 'formnovalidate' => true))
            );
        $form->handleRequest($request);
        if ($form->get('cancel')->isClicked()) {
            return $this->redirectToRoute('promotion_list_c');
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($Promotion);
            $entityManager->flush();

            $this->addFlash("info", "Promotion with name " . $Promotion->getName() . " was added successfully");


            return $this->redirectToRoute('promotion_list_c');


        }


        return $this->render('@Shop/Promotion/create.html.twig',
            ['PromotionForm' => $form->createView()]);


    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @param $id
     * @Route("promotion/create/product", name="promotion_add_process_p")
     * @Method({"POST"})
     */
    public function addProductPromotionProccessActon(Request $request)

    {
        $Promotion = new Promotion();
        $form = $this->createForm(ProductPromotionType::class, $Promotion)
            ->add("create", SubmitType::class, array(
                'attr' => array('class' => 'btn-success', 'formnovalidate' => true)))
            ->add("cancel", SubmitType::class, array(
                    'attr' => array('class' => 'btn-primary', 'formnovalidate' => true))
            );
        $form->handleRequest($request);
        if ($form->get('cancel')->isClicked()) {
            return $this->redirectToRoute('promotion_list_p');
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($Promotion);
            $entityManager->flush();

            $this->addFlash("info", "Promotion with name " . $Promotion->getName() . " was added successfully");


            return $this->redirectToRoute('promotion_list_p');


        }


        return $this->render('@Shop/Promotion/create.html.twig',
            ['PromotionForm' => $form->createView()]);


    }

    /**
     * @return \Symfony\Component\HttpFoundation\Response
     * @param $id
     * @Route("promotion/create/user", name="promotion_add_process_u")
     * @Method({"POST"})
     */
    public function addUserPromotionProccessActon(Request $request)

    {
        $Promotion = new Promotion();
        $form = $this->createForm(UserPromotionType::class, $Promotion)
            ->add("create", SubmitType::class, array(
                'attr' => array('class' => 'btn-success', 'formnovalidate' => true)))
            ->add("cancel", SubmitType::class, array(
                    'attr' => array('class' => 'btn-primary', 'formnovalidate' => true))
            );
        $form->handleRequest($request);
        if ($form->get('cancel')->isClicked()) {
            return $this->redirectToRoute('promotion_list_p');
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($Promotion);
            $entityManager->flush();

            $this->addFlash("info", "Promotion with name " . $Promotion->getName() . " was added successfully");


            return $this->redirectToRoute('promotion_list_u');


        }


        return $this->render('@Shop/Promotion/create.html.twig',
            ['PromotionForm' => $form->createView()]);


    }


    /**
     *
     * @Route("promotion/edit/category/{id}", name="promotion_edit_c")
     * @Method({"GET"})
     *
     * @param Promotion $promotion
     * @return Response
     */

    public function editCategoryPromotionAction(Promotion $promotion)
    {


        $form = $this->createForm(CategoryPromotionType::class, $promotion)
            ->add("edit", SubmitType::class, array(
                'attr' => array('class' => 'btn-warning', 'formnovalidate' => true)))
            ->add("cancel", SubmitType::class, array(
                'attr' => array('class' => 'btn-primary', 'formnovalidate' => true)));

        return $this->render('@Shop/Promotion/edit.html.twig', ['editForm' => $form->createView()]);

    }

    /**
     *
     * @Route("promotion/edit/product/{id}", name="promotion_edit_p")
     * @Method({"GET"})
     *
     * @param Promotion $promotion
     * @return Response
     */

    public function editProductPromotionAction(Promotion $promotion)
    {


        $form = $this->createForm(ProductPromotionType::class, $promotion)
            ->add("edit", SubmitType::class, array(
                'attr' => array('class' => 'btn-warning', 'formnovalidate' => true)))
            ->add("cancel", SubmitType::class, array(
                'attr' => array('class' => 'btn-primary', 'formnovalidate' => true)));

        return $this->render('@Shop/Promotion/edit.html.twig', ['editForm' => $form->createView()]);

    }


    /**
     *
     * @Route("promotion/edit/user/{id}", name="promotion_edit_u")
     * @Method({"GET"})
     *
     * @param Promotion $promotion
     * @return Response
     */

    public function editUserPromotionAction(Promotion $promotion)
    {


        $form = $this->createForm(UserPromotionType::class, $promotion)
            ->add("edit", SubmitType::class, array(
                'attr' => array('class' => 'btn-warning', 'formnovalidate' => true)))
            ->add("cancel", SubmitType::class, array(
                'attr' => array('class' => 'btn-primary', 'formnovalidate' => true)));

        return $this->render('@Shop/Promotion/edit.html.twig', ['editForm' => $form->createView()]);

    }


    /**
     * @param Promotion $promotion
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     *
     * @Method({"POST"})
     * @Route("promotion/edit/category/{id}", name="promotion_edit_process_c")
     */

    public function editCategoryPromotionProcessAction(Promotion $promotion, Request $request)

    {
        $form = $this->createForm(CategoryPromotionType::class, $promotion)
            ->add("edit", SubmitType::class, array(
                'attr' => array('class' => 'btn-warning')))
            ->add("cancel", SubmitType::class, array(
                'attr' => array('class' => 'btn-primary', 'name' => 'cancel', 'formnovalidate' => true)));

        $form->handleRequest($request);


        if ($form->get('cancel')->isClicked()) {
            return $this->redirectToRoute('promotion_list_c');
        }
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($promotion);
            $entityManager->flush();
            $this->addFlash("info", "Promotion with name " . $promotion->getName() . " was edited successfully");

            return $this->redirectToRoute('promotion_list_c');

        }


        return $this->render('@Shop/Promotion/edit.html.twig', ['editForm' => $form->createView()]);
    }

    /**
     * @param Promotion $promotion
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     *
     * @Method({"POST"})
     * @Route("promotion/edit/product/{id}", name="promotion_edit_process_p")
     */

    public function editProductPromotionProcessAction(Promotion $promotion, Request $request)

    {
        $form = $this->createForm(ProductPromotionType::class, $promotion)
            ->add("edit", SubmitType::class, array(
                'attr' => array('class' => 'btn-warning')))
            ->add("cancel", SubmitType::class, array(
                'attr' => array('class' => 'btn-primary', 'name' => 'cancel', 'formnovalidate' => true)));

        $form->handleRequest($request);


        if ($form->get('cancel')->isClicked()) {
            return $this->redirectToRoute('promotion_list_p');
        }
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($promotion);
            $entityManager->flush();
            $this->addFlash("info", "Promotion with name " . $promotion->getName() . " was edited successfully");

            return $this->redirectToRoute('promotion_list_p');

        }


        return $this->render('@Shop/Promotion/edit.html.twig', ['editForm' => $form->createView()]);
    }

    /**
     * @param Promotion $promotion
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     *
     * @Method({"POST"})
     * @Route("promotion/edit/user/{id}", name="promotion_edit_process_u")
     */

    public function editUserPromotionProcessAction(Promotion $promotion, Request $request)

    {
        $form = $this->createForm(UserPromotionType::class, $promotion)
            ->add("edit", SubmitType::class, array(
                'attr' => array('class' => 'btn-warning')))
            ->add("cancel", SubmitType::class, array(
                'attr' => array('class' => 'btn-primary', 'name' => 'cancel', 'formnovalidate' => true)));

        $form->handleRequest($request);


        if ($form->get('cancel')->isClicked()) {
            return $this->redirectToRoute('promotion_list_u');
        }
        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($promotion);
            $entityManager->flush();
            $this->addFlash("info", "Promotion with name " . $promotion->getName() . " was edited successfully");

            return $this->redirectToRoute('promotion_list_p');

        }


        return $this->render('@Shop/Promotion/edit.html.twig', ['editForm' => $form->createView()]);
    }


    /**
     * @param Promotion $promotion
     * @Method({"POST"})
     *
     * @Route("promotion/delete/{id}/category", name="promotion_delete_c")
     */
    public function deletePromotionAction(Promotion $promotion)
    {

        try {
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($promotion);
            $manager->flush();


        } catch (\Exception $e) {
            $this->addFlash("error", 'Cant delete Promotion');
            return $this->redirectToRoute("manage_main");
        }
        $this->addFlash("delete", "Promotion deleted!!!");
        return $this->redirectToRoute("promotion_list_c");

    }

    /**
     * @param Promotion $promotion
     * @Method({"POST"})
     *
     * @Route("promotion/delete/{id}/product", name="promotion_delete_p")
     */
    public function deleteProductPromotionAction(Promotion $promotion)
    {

        try {
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($promotion);
            $manager->flush();


        } catch (\Exception $e) {
            $this->addFlash("error", 'Cant delete Promotion');
            return $this->redirectToRoute("manage_main");
        }
        $this->addFlash("delete", "Promotion deleted!!!");
        return $this->redirectToRoute("promotion_add_p");

    }


    /**
     * @param Promotion $promotion
     * @Method({"POST"})
     *
     * @Route("promotion/delete/{id}/user", name="promotion_delete_u")
     */
    public function deleteUserPromotionAction(Promotion $promotion)
    {

        try {
            $manager = $this->getDoctrine()->getManager();
            $manager->remove($promotion);
            $manager->flush();


        } catch (\Exception $e) {
            $this->addFlash("error", 'Cant delete Promotion');
            return $this->redirectToRoute("manage_main");
        }
        $this->addFlash("delete", "Promotion deleted!!!");
        return $this->redirectToRoute("promotion_add_u");

    }
}
