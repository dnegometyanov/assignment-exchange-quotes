<?php
namespace App\CommandHandler;

use App\Command\CreateHistoricalQuotesTaskCommand;
use App\Command\GetAndUpdateHistoricalQuotesCommand;
use App\Entity\HistoricalQuotesTask;
use App\Repository\TaskRepository;
use DateTimeImmutable as DateTimeImmutable;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpClient\HttpClient;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GetAndUpdateHistoricalQuotesCommandHandler
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
     * @var HttpClientInterface
     */
    private HttpClientInterface $httpClient;

    public function __construct(
        TaskRepository $taskRepository,
        EntityManagerInterface $em,
        HttpClientInterface $httpClient
    )
    {
        $this->taskRepository = $taskRepository;
        $this->em = $em;
        $this->httpClient = $httpClient;
    }

    public function handle(GetAndUpdateHistoricalQuotesCommand $command)
    {
        $task = $this->taskRepository->find($command->getTaskUuid());

        $task->setData(['xx'=>'yy']);
        $task->setIsNotified(true);

        $this->em->flush();

        return $task;
    }
}