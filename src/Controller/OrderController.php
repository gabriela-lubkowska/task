<?php

namespace App\Controller;

use App\Entity\CurrencyOrder;
use App\Entity\CurrencyOrderItem;
use App\Entity\PickupPoint;
use App\Form\OrderType;
use App\Repository\PickupPointRepository;
use App\Service\CartService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    public CartService $cartService;

    public function __construct(
        CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    /**
     * @Route("/order/create", name="order_create")
     */
    public function createOrder(Request $request): Response
    {
        $order = new CurrencyOrder();
        $pickupPoints = $this->getDoctrine()->getRepository(PickupPoint::class)->findAll();

        $form = $this->createForm(OrderType::class, $order, [
            'pickup_points' => $pickupPoints
        ]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // Fill order data
            $order->setUser($this->getUser());

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($order);
            $entityManager->flush();

            // Optionally clear cart items after successful order placement
            $cart = $this->getUser()->getCart();
            $this->cartService->clearCart($cart);

            return $this->redirectToRoute('order_success'); // Or any other route to display a success message
        }

        return $this->render('order/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/order/success", name="order_success")
     */
    public function orderSuccess(): Response
    {
        return $this->render('order/success.html.twig');
    }

    /**
     * @Route("/order/place", name="order_place")
     */
    public function placeOrder(Request $request): Response {
        $user = $this->getUser();
        $cart = $user->getCart();
        $order = new CurrencyOrder();
        $order->setUser($user);

        $pickupPoints = $this->getDoctrine()->getRepository(PickupPoint::class)->findAll();
        $form = $this->createForm(OrderType::class, $order, [
            'pickup_points' => $pickupPoints
        ]);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $order = $form->getData();
            foreach ($cart->getItems() as $cartItem) {
                $orderItem = new CurrencyOrderItem();
                $orderItem->setCurrency($cartItem->getCurrency());
                $orderItem->setQuantity($cartItem->getQuantity());
                $order->addOrderItem($orderItem);
            }

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($order);
            $entityManager->flush();

            // Clear cart after order placement
            foreach ($cart->getOrderItems() as $cartItem) {
                $entityManager->remove($cartItem);
            }
            $entityManager->flush();

            return $this->redirectToRoute('order_success');
        }

        return $this->render('order/create.html.twig', [
            'form' => $form->createView(),
            'pickupPoints' => $pickupPoints
        ]);
    }
}