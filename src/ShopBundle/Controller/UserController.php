<?php

namespace ShopBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use ShopBundle\Entity\Role;
use ShopBundle\Entity\User;
use ShopBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class UserController extends Controller
{
    /**
     * @Route("register", name="user_register_form")
     * @Method("GET")
     * @return \Symfony\Component\HttpFoundation\Response
     *
     */

    public function registerAction()
    {
        $form = $this->createForm(UserType::class);
        return $this->render('@Shop/users/register.html.twig',
            ['formUser' => $form->createView()]);
    }

    /**
     * @param Request $request
     * @Route("register",name="user_register_process_form")
     * @Method("POST")
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */

    public function registerProcessAction(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $form->handleRequest($request);
        $encoder = $this->get('security.password_encoder');

        if ($form->isSubmitted() && $form->isValid()) {
            $hashPassword = $encoder->encodePassword(
                $user,
                $user->getPassword()
            );
            $user->setPassword($hashPassword);
            $userRole = $this->getDoctrine()->getRepository(Role::class)
                ->findOneBy(['name' => 'ROLE_USER']);
            $user->addRole($userRole);
            $user->setCache(10000);
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($user);
            $entityManager->flush();

            return $this->redirectToRoute('our_login');


        }

        return $this->render('@Shop/users/register.html.twig',
            ['formUser' => $form->createView()]);

    }


    /**
     * @Security("is_granted('IS_AUTHENTICATED_FULLY')")
     * @Route("profile", name="user_profile")
     *
     */
    public function profileAction()
    {
        $user = $this->getUser();
        return $this->render('@Shop/users/profile.html.twig', ['user' => $user]);
    }
}
