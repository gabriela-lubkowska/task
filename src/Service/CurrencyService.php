<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Currency;
use App\Repository\CurrencyRepository;
use Doctrine\ORM\EntityManagerInterface;

final class CurrencyService
{

    public function __construct(
        private EntityManagerInterface $entityManager,
        private CurrencyRepository $currencyRepository,
        private NbpApiService $nbpApiService
    ) { }

    public function updateExchangeRates(): void
    {
        $exchangeRates = $this->nbpApiService->getExchangeRates();

        if (count($exchangeRates) == 0) {
            // Handle the case where there are zero sets of rates.
            // You could log an error or throw an exception here.
            return;
        }

        $mostRecentExchangeRates = end($exchangeRates)['rates'] ?? [];
        $secondMostRecentExchangeRates = prev($exchangeRates)['rates'] ?? [];

        foreach ($mostRecentExchangeRates as $index => $exchangeRate) {
            $currencyCode = $exchangeRate['code'];
            $currency = $this->currencyRepository->findOneBy(['currencyCode' => $currencyCode]);

            if (!$currency) {
                $currency = new Currency();
                $currency->setCurrencyCode($currencyCode);
            }

            $roundedMostRecentExchangeRate = (int)round($exchangeRate['mid'] * 100, 0);
            $currency->setName($exchangeRate['currency']);
            $currency->setExchangeRate($roundedMostRecentExchangeRate);

            if (!empty($secondMostRecentExchangeRates)) {
                $secondMostRecentExchangeRate = $secondMostRecentExchangeRates[$index]['code'] ?? null;

                if (null !== $secondMostRecentExchangeRate && $secondMostRecentExchangeRate === $currencyCode) {
                    $roundedSecondMostRecentExchangeRate = (int)round($secondMostRecentExchangeRates[$index]['mid'] * 100, 0);
                    $currency->setYesterdayExchangeRate($roundedSecondMostRecentExchangeRate);
                }
            }

            $this->entityManager->persist($currency);
        }

        $this->entityManager->flush();
    }
}
