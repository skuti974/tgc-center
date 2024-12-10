<?php

declare(strict_types=1);

namespace Tgc\Realm\Pokemon\Command;

use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;
use Symfony\Component\Messenger\Exception\ExceptionInterface;
use Symfony\Component\Messenger\MessageBusInterface;
use Tgc\Realm\Pokemon\Message\SynchronizeMessage;

#[AsCommand(name: 'tgc:synchronize:pokemon', description: 'Fetch Pokémon data from API and synchronize it with database')]
class PokemonSynchronizerCommand extends Command
{
    public function __construct(
        private readonly MessageBusInterface $bus,
        private readonly array $locales
    ) {
        parent::__construct();
    }

    public function configure(): void
    {
        $this->addArgument('locales', InputArgument::IS_ARRAY, 'The locales you want to synchronize.');
    }

    /**
     * @throws ExceptionInterface
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);
        $io->title('Synchronizing Pokemon data');

        $locales = $input->getArgument('locales');
        if (empty($locales)) {
            $locales = $this->locales;
        }

        foreach ($locales as $locale) {
            $io->info('Request synchronizing Pokemon for locale ' . $locale);
            $this->bus->dispatch(new SynchronizeMessage($locale));
        }

        $io->success('Synchronization requested.');

        return Command::SUCCESS;
    }
}
