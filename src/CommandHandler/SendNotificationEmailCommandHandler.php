<?php declare(strict_types=1);

namespace App\CommandHandler;

use App\Command\SendNotificationEmailCommand;
use App\Repository\HistoricalQuotesTaskRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;

class SendNotificationEmailCommandHandler
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
     * @var \Swift_Mailer
     */
    private \Swift_Mailer $mailer;

    public function __construct(
        HistoricalQuotesTaskRepositoryInterface $taskRepository,
        EntityManagerInterface $em,
        \Swift_Mailer $mailer
    )
    {
        $this->taskRepository = $taskRepository;
        $this->em             = $em;
        $this->mailer         = $mailer;
    }

    public function handle(SendNotificationEmailCommand $command)
    {
        $task = $this->taskRepository->find($command->getTaskUuid());

        $message = (new \Swift_Message($command->getCompanyName()))
            ->setFrom('denis.negometyanov@gmail.com')
            ->setTo($command->getEmail())
            ->setBody(
                sprintf(
                    'From %s to %s',
                    $command->getDateFrom(),
                    $command->getDateTo()
                )
            );

        $res = $this->mailer->send($message);

        $task->setIsNotified(true);

        $this->em->flush();

        return $task;
    }
}
