<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BalanceController extends AbstractController
{
    /**
     * @Route("/add-balance", name="add_balance")
     */
    public function addBalance(): Response
    {
        $user = $this->getUser(); // Get the currently logged-in user

        if (!$user) {
            throw $this->createNotFoundException('User not found');
        }

        $userId = $user->getId();

        return $this->render('currency/add_balance.html.twig', [
            'userId' => $userId,
        ]);
    }
}