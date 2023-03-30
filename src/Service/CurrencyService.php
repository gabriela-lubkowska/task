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
        $yesterdayExchangeRates = $exchangeRates[0]['rates'];
        $todayExchangeRates = $exchangeRates[1]['rates'];

        foreach ($todayExchangeRates as $index => $exchangeRate) {
            $currencyCode = $exchangeRate['code'];
            $currency = $this->currencyRepository->findOneBy(['currencyCode' => $currencyCode]);

            if (!$currency) {
                $currency = new Currency();
                $currency->setCurrencyCode($currencyCode);
            }
            $yesterdayExchangeRate = $yesterdayExchangeRates[$index]['code'];
            $roundedTodayExchangeRate = (int)round($exchangeRate['mid'] * 100, 0);
            $currency->setName($exchangeRate['currency']);
            $currency->setExchangeRate($roundedTodayExchangeRate);

            if (null !== $yesterdayExchangeRate && $yesterdayExchangeRate === $currencyCode) {
                $roundedYesterdayExchangeRate = (int)round($yesterdayExchangeRates[$index]['mid'] * 100, 0);
                $currency->setYesterdayExchangeRate($roundedYesterdayExchangeRate);
            }

            $this->entityManager->persist($currency);
        }

        $this->entityManager->flush();
    }
}
