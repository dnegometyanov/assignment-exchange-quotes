<?php
namespace App\CommandHandler;

use App\Command\CreateHistoricalQuotesTaskCommand;
use App\Entity\HistoricalQuotesTask;
use App\Message\EmailNotificationEvent;
use App\Message\HistoricalQuotesRequestEvent;
use App\Repository\HistoricalQuotesTaskRepositoryInterface;
use App\Repository\ListingRepository;
use DateTime as DateTime;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Messenger\MessageBusInterface;

class CreateHistoricalQuotesTaskCommandHandler
{
    /**
     * @var HistoricalQuotesTaskRepositoryInterface
     */
    private HistoricalQuotesTaskRepositoryInterface $taskRepository;
    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;
    /**
     * @var MessageBusInterface
     */
    private MessageBusInterface $bus;
    /**
     * @var ListingRepository
     */
    private ListingRepository $listingRepository;

    public function __construct(
        HistoricalQuotesTaskRepositoryInterface $taskRepository,
        ListingRepository $listingRepository,
        EntityManagerInterface $em,
        MessageBusInterface $bus)
    {
        $this->taskRepository    = $taskRepository;
        $this->em                = $em;
        $this->bus               = $bus;
        $this->listingRepository = $listingRepository;
    }

    public function handle(CreateHistoricalQuotesTaskCommand $command)
    {
        $task = new HistoricalQuotesTask(
            $command->getSymbol(),
            new DateTime($command->getDateFrom()),
            new DateTime($command->getDateTo()),
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

        $listing = $this->listingRepository->findOneBySymbol($command->getSymbol());

        if (!$listing) {
            throw new \RuntimeException(sprintf('Listing for symbol %s not found', $command->getSymbol()));
        }

        $this->bus->dispatch(
            new EmailNotificationEvent(
                $task->getUuid(),
                $command->getEmail(),
                $listing->getCompanyName(),
                $command->getDateFrom(),
                $command->getDateTo(),
            )
        );

        return $task;
    }
}