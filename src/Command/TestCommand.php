<?php

namespace App\Command;

use App\Realm\Common\RealmManager;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

#[AsCommand(
    name: 'app:test',
    description: 'A simple command for testing',
)]
final class TestCommand extends Command
{
    public function __construct(
        private readonly RealmManager $realmManager,
    ) {
        parent::__construct();
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $this->realmManager->realms();
        return Command::SUCCESS;
    }
}
