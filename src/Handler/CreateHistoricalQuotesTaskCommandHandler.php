<?php
namespace App\Handler;

use App\Command\CreateHistoricalQuotesTaskCommand;
use App\Entity\HistoricalQuotesTask;
use App\Repository\TaskRepository;
use DateTimeImmutable as DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;

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

    public function __construct(TaskRepository $taskRepository, EntityManagerInterface $em)
    {
        $this->taskRepository = $taskRepository;
        $this->em = $em;
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

        return $task;
    }
}