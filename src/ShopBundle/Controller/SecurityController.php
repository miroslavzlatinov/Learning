<?php

namespace ShopBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;


class SecurityController extends Controller
{
    /**
     * @Route("login", name="our_login")
     */
    public function loginAction(Request $request)
    {


        $authenticationUtils = $this->get('security.authentication_utils');

        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();

        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();


        return $this->render('@Shop/security/login.html.twig',
            [
                'last_username' => $lastUsername,
                'error' => $error]
        );

    }

    /**
     * @Route("/login_check", name="our_login_check")
     * @param Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function checkAction(Request $request)
    {
        return $this->redirectToRoute('form_login');
    }


    /**
     * @Route("logout",name="logout")
     *
     *
     */

    public function logoutAction()
    {


    }
}
