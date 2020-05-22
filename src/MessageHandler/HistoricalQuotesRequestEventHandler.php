<?php declare(strict_types=1);

namespace App\MessageHandler;

use App\Command\GetAndUpdateHistoricalQuotesCommand;
use App\Message\HistoricalQuotesRequestEvent;
use League\Tactician\CommandBus;
use Symfony\Component\Messenger\Handler\MessageHandlerInterface;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class HistoricalQuotesRequestEventHandler implements MessageHandlerInterface
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

    public function __invoke(HistoricalQuotesRequestEvent $historicalQuotesRequestEvent): void
    {
        $command = new GetAndUpdateHistoricalQuotesCommand(
            $historicalQuotesRequestEvent->getTaskUuid(),
            $historicalQuotesRequestEvent->getSymbol(),
            $historicalQuotesRequestEvent->getDateFrom(),
            $historicalQuotesRequestEvent->getDateTo(),
        );

        /**
         * @var ConstraintViolationList
         */
        $violations = $this->validator->validate($command);
        // TODO handle violations ?

        $this->commandBus->handle($command);
    }
}
