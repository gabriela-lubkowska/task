<?php

declare(strict_types=1);

namespace App\Controller;

use App\Entity\Currency;
use App\Service\CurrencyService;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

final class CurrencyController extends AbstractController
{
    public function __construct(private CurrencyService $currencyService) { }

    #[Route('/', name: 'currency_list')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        $currencies = $entityManager->getRepository(Currency::class)->findAll();
        return $this->render('currency/index.html.twig', [
            'currencies' => $currencies,
        ]);
    }

    #[IsGranted('ROLE_ADMIN')]
    #[Route('/currency/update-exchange-rates', name: 'currency_update_exchange_rates')]
    public function updateExchangeRates(): Response
    {
        $this->currencyService->updateExchangeRates();

        return new Response('Exchange rates updated!');
    }
}
