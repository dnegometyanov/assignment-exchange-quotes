<?php
namespace App\CommandHandler;

use App\Command\CreateHistoricalQuotesTaskCommand;
use App\Entity\HistoricalQuotesTask;
use App\Message\HistoricalQuotesRequestEvent;
use App\Repository\TaskRepository;
use DateTimeImmutable as DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class CreateHistoricalQuotesTaskCommandHandler
{
    /**
     * @var TaskRepository
     */
    private TaskRepository $taskRepository;
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;
    /**
     * @var MessageBusInterface
     */
    private MessageBusInterface $bus;

    public function __construct(
        TaskRepository $taskRepository,
        EntityManagerInterface $em,
        MessageBusInterface $bus)
    {
        $this->taskRepository = $taskRepository;
        $this->em             = $em;
        $this->bus            = $bus;
    }

    public function handle(CreateHistoricalQuotesTaskCommand $command)
    {
        $task = new HistoricalQuotesTask(
            $command->getSymbol(),
            new DateTimeImmutable($command->getDateFrom()),
            new DateTimeImmutable($command->getDateTo()),
            $command->getEmail(),
        );

        $this->em->persist($task);
        $this->em->flush();

        $this->bus->dispatch(
            new HistoricalQuotesRequestEvent(
                $task->getUuid(),
                $command->getSymbol(),
                $command->getDateFrom(),
                $command->getDateTo(),
            )
        );

        return $task;
    }
}