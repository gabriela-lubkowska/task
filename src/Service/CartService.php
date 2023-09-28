<?php

namespace App\Service;

use App\Entity\Cart;
use App\Entity\CartItem;
use Doctrine\ORM\EntityManagerInterface;

class CartService
{
    private $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function clearCart(Cart $cart): void
    {
        $cartItems = $cart->getItems(); // Assuming you have a getItems() method in your Cart entity
        foreach ($cartItems as $item) {
            $this->em->remove($item);
        }
        $this->em->flush();
    }
}
