<?php

namespace App\Console;

use App\Command\ImportListingCommand;
use Doctrine\ORM\EntityManagerInterface;
use League\Tactician\CommandBus;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface as OutputInterface;

class ImportListingConsoleCommand extends Command
{
    /**
     * @var CommandBus
     */
    private CommandBus $commandBus;

    public function __construct(
        CommandBus $commandBus
    )
    {
        parent::__construct();

        $this->commandBus = $commandBus;
    }

    protected function configure()
    {
        $this
            ->setName('app:listing:import')
            ->setDescription('Imports listing.');
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->commandBus->handle(new ImportListingCommand());

        $output->writeln('Listing successfully imported');

        return 0;
    }
}