<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Cart;
use App\Entity\CartItem;
use App\Entity\Currency;

class CartController extends AbstractController
{
    /**
     * @Route("/cart", name="cart_index")
     */
    public function index(): Response
    {
        $user = $this->getUser();
        $cart = $user->getCart();
        return $this->render('cart/index.html.twig', [
            'cart' => $cart,
        ]);
    }

    /**
     * @Route("/cart/add/{currencyId}", name="cart_add", methods={"POST"})
     */
    public function addItem(Request $request, $currencyId): Response
    {
        $user = $this->getUser();
        if (!$user) {
            return $this->redirectToRoute('app_login');
        }

        $quantity = $request->request->getInt('quantity', 1);

        $entityManager = $this->getDoctrine()->getManager();

        $currency = $entityManager->getRepository(Currency::class)->find($currencyId);
        if (!$currency) {
            // If the currency doesn't exist, redirecting to the cart seems a reasonable fallback
            return $this->redirectToRoute('cart_index');
        }

        $cart = $user->getCart();
        if (!$cart) {
            $cart = new Cart();
            $cart->setUser($user);
            $entityManager->persist($cart);
        }

        $cartItem = new CartItem();
        $cartItem->setCart($cart);
        $cartItem->setCurrency($currency);
        $cartItem->setQuantity($quantity);

        $entityManager->persist($cartItem);
        $entityManager->flush();

        $referer = $request->headers->get('referer', $this->generateUrl('currency_list'));
        return $this->redirect($referer);
    }

    /**
     * @Route("/cart/remove/{itemId}", name="cart_remove")
     */
    public function removeItem($itemId): Response
    {
        $user = $this->getUser();
        $entityManager = $this->getDoctrine()->getManager();

        $cartItem = $entityManager->getRepository(CartItem::class)->find($itemId);
        if ($cartItem && $cartItem->getCart()->getUser() === $user) {
            $entityManager->remove($cartItem);
            $entityManager->flush();
        }

        return $this->redirectToRoute('cart_index');
    }
}