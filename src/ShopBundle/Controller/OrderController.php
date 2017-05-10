<?php

namespace ShopBundle\Controller;


use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use ShopBundle\Entity\Orders;
use ShopBundle\Entity\OrdersProduct;
use ShopBundle\Events\OrderWasCreated;
use ShopBundle\Form\OrdersType;
use ShopBundle\Listeners\EmptyBasket;
use ShopBundle\Listeners\FailedPayment;
use ShopBundle\Listeners\MarkOrderPaid;
use ShopBundle\Listeners\SuccessfulPayment;
use ShopBundle\Listeners\UpdateStock;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\EventDispatcher\EventDispatcher;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class OrderController extends Controller
{


    /**
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     *
     * @Route("/order", name="order_index")
     * @Method("GET")
     */


    public function indexAction()
    {


        $form = $this->createForm(OrdersType::class);
        $this->get('basket')->refresh();
        if (!$this->get('basket')->subTotal()) {
            return $this->redirectToRoute('cart_index');
        }
//        $securityContext = $this->get('security.authorization_checker');
//
//        if ($securityContext->isGranted('IS_AUTHENTICATED_FULLY')) {
//            $user = $this->getUser();
//            $details = $this->getDoctrine()->getRepository('ShopBundle:Customers')
//                ->findOneBy(['user' => $user->getId()]);
//            $address = $this->getDoctrine()->getRepository('ShopBundle:Addresses')
//                ->findOneBy(['user' => $user->getId()]);
//            $order = new Orders();
//            $order->setAddressId($address);
//            $order->setCustomerId($details);
//
//            if ($order) {
//                $form->setData($order);
//            }
//
//        }
        return $this->render('@Shop/order/index_back.html.twig',
            ['customerForm' => $form->createView()
            ]);
    }

    /**
     * @param $hash
     * @param Request $request
     *
     *
     * @param Orders $order
     * @return mixed
     *
     * @Route("/order/{hash}", name="order_show")
     */


    public function back_show(Request $request)
    {


        $order = $this->getDoctrine()->getRepository("ShopBundle:Orders")
            ->findOneBy(['hash' => $request->get('hash')]);


        if (!$order) {
            return $this->redirectToRoute('store_main');
        }

        return $this->render('@Shop/order/back_show.htm.twig', [
            'order' => $order,
        ]);
    }


    /**
     * @param Request $request
     *
     * @return mixed
     *
     *
     * @Route("/order", name="order_create")
     *
     *
     */

    public function create(Request $request)
    {
        $this->get('basket')->refresh();


        if (!$this->get('basket')->subTotal()) {
            $this->redirectToRoute('order_index');
        }

        /*  if (!$request->getParam('payment_method_nonce')) {
               $this->redirectToRoute('order.index');
           }*/
        $hash = bin2hex(random_bytes(10));

        $total = $this->get('basket')->subTotal();
        $products = $this->get('basket')->all();

        $order = new Orders();
        $order->setHash($hash);
        $order->setTotal($total + 5);
        // dump($products);exit;
        $order->setProducts = $products;
        $order->setPaid('false');

        $form = $this->createForm(OrdersType::class, $order);
        $em = $this->getDoctrine()->getManager();


        $form->handleRequest($request);
        $customer = $form->get('customerId')->getData();
        $customer->setUser($this->getUser());

        if ($form->isSubmitted() && $form->isValid()) {
            $em->getConnection()->beginTransaction();
            try {

                $em->persist($order);
                $em->persist($customer);
                $em->flush();
                foreach ($products as $p) {
                    $orderProducts = new OrdersProduct();
                    $orderProducts->setProductId($p);
                    $orderProducts->setQuantity($p->quantity);
                    $orderProducts->setOrderId($order);
                    $em->persist($orderProducts);
                    $em->flush();
                    // dump($form->getData());

                }
                $em->getConnection()->commit();
                // exit;
            } catch (\Exception $e) {
                $em->getConnection()->rollback();

                return $this->redirectToRoute('order_index');
            }
            $paid ='';
            $user ='';
            $securityContext = $this->get('security.authorization_checker');
            if ($securityContext->isGranted('IS_AUTHENTICATED_FULLY')) {
                $user = $this->getUser();
                $cache = $em->getRepository('ShopBundle:User')
                    ->createQueryBuilder('c')
                    ->where('c.id = :id')
                    ->select('c.cache')
                    ->setParameter('id', $this->getUser())
                    ->getQuery()->getScalarResult();
                $in = array_map(function ($in) {
                    return $in['cache'];
                }, $cache);
                $spent = $this->get('basket')->subTotal() + 5;
               // dump($in);exit;
                $before = $in[0];
                $paid = ($before < $spent);

            }
            $event = new OrderWasCreated($order, $this->get('basket'));
            $dispatcher = new EventDispatcher();




            $failedpay = new FailedPayment($em);
            $clear = new EmptyBasket();

            if ($paid) {
                $dispatcher->addListener('order.placed', array($failedpay, 'onOrderAction'), 100);
                $dispatcher->addListener('order.placed', array($clear, 'onOrderAction'), 97);
                $dispatcher->dispatch('order.placed', $event);
                return $this->redirectToRoute('user_order_view', ['hash' => $hash]);
            }




            $orderpaid = new MarkOrderPaid();

            $fullp = new SuccessfulPayment($em, $user);
            $stock = new UpdateStock($em);


            $dispatcher->addListener('order.placed', array($orderpaid, 'onOrderAction'), 100);
            $dispatcher->addListener('order.placed', array($stock, 'onOrderAction'), 99);
            $dispatcher->addListener('order.placed', array($fullp, 'onOrderAction'), 98);
            $dispatcher->addListener('order.placed', array($clear, 'onOrderAction'), 97);


            $dispatcher->dispatch('order.placed', $event);


            return $this->redirectToRoute('user_order_view', ['hash' => $hash]);


        }
    }

    /**
     * @return Response
     *
     * @Route("/order/profile/list" , name="user_order_list")
     *
     */
    public function userOrdersAction()
    {
        $user = $this->getUser();

        $orders = $this->getDoctrine()->getRepository('ShopBundle:Orders')
            ->findUserOrders($user);
        if (!$orders) {
            return $this->redirectToRoute('user_profile');

        }
        return $this->render('@Shop/users/user_orders.html.twig', ['orders' => $orders]);

    }

    /**
     * @param Request $request
     * @return Response
     * @Route("/order/profile/{hash}" ,name="user_order_view")
     *
     */


    public function userOrder(Request $request)
    {

        $slug = $request->attributes->get('hash');

//        $order = $this->getDoctrine()->getRepository("ShopBundle:Orders")
//            ->findOrdersWithAC($slug);
        $order = $this->getDoctrine()->getRepository("ShopBundle:Orders")
            ->findOneBy(['hash' => $slug]);

        return $this->render('@Shop/users/user_order.html.twig', ['order' => $order]);

    }


}