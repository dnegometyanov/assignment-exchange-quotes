<?php declare(strict_types=1);

namespace App\Console;

use App\Command\ImportListingCommand;
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

    protected function configure(): void
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
