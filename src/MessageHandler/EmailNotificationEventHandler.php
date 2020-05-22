<?php

namespace App\MessageHandler;

use App\Command\SendNotificationEmailCommand;
use App\Message\EmailNotificationEvent;
use League\Tactician\CommandBus;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class EmailNotificationEventHandler implements MessageHandlerInterface
{
    /**
     * @var CommandBus
     */
    private CommandBus $commandBus;

    /**
     * @var ValidatorInterface
     */
    private ValidatorInterface $validator;

    public function __construct(CommandBus $commandBus, ValidatorInterface $validator)
    {
        $this->commandBus = $commandBus;
        $this->validator  = $validator;
    }

    public function __invoke(EmailNotificationEvent $emailNotificationEvent)
    {
        $command = new SendNotificationEmailCommand(
            $emailNotificationEvent->getTaskUuid(),
            $emailNotificationEvent->getEmail(),
            $emailNotificationEvent->getCompanyName(),
            $emailNotificationEvent->getDateFrom(),
            $emailNotificationEvent->getDateTo(),
        );

        /**
         * @var ConstraintViolationList
         */
        $violations = $this->validator->validate($command);
        // TODO handle violations ?

        $this->commandBus->handle($command);
    }
}