<?php

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

    /**
     * @var string
     */
    private string $xRapidApiKey;

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

        $message = (new \Swift_Message('Hello Email'))
            ->setFrom('denis.negometyanov@gmail.com')
            ->setTo('denis.negometyanov@gmail.com')
            ->setBody('Hello World');

        $res = $this->mailer->send($message);

        $task->setIsNotified(true);

        $this->em->flush();

        return $task;
    }
}