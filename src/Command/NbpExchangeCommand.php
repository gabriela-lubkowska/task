<?php

declare(strict_types=1);

namespace App\Command;

use App\Service\CurrencyService;
use Exception;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

final class NbpExchangeCommand extends Command
{
    protected static $defaultName = 'nbp:exchanges:update';
    protected static $defaultDescription = 'Update exchange rates from NBP';

    public function __construct(
        private CurrencyService $currencyService,
    ) {
        parent::__construct();
    }

    protected function configure()
    {
        $this->setDescription(self::$defaultDescription);
        $this->setName(self::$defaultName);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        try {
            $this->currencyService->updateExchangeRates();
        } catch (Exception $e) {
            $output->writeln(sprintf('Exchange rates were not loaded due to %s', $e->getMessage()));
            return Command::FAILURE;
        }

        $output->writeln('Exchange rates updated in database.');
        return Command::SUCCESS;
    }
}
