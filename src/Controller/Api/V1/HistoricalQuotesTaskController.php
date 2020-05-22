<?php

namespace App\Controller\Api\V1;

use App\Command\CreateHistoricalQuotesTaskCommand;
use App\Entity\HistoricalQuotesTask;
use League\Tactician\CommandBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/api/v1/task")
 */
class HistoricalQuotesTaskController
{
    /**
     * @Route("/", methods={"POST"}, name="create_historical_quotes_task")
     *
     * @param Request $request
     * @param ValidatorInterface $validator
     * @param CommandBus $commandBus
     * @return JsonResponse
     */
    public function createTask(Request $request, ValidatorInterface $validator, CommandBus $commandBus)
    {
        $command = new CreateHistoricalQuotesTaskCommand(
            $request->get('symbol'),
            $request->get('date_from'),
            $request->get('date_to'),
            $request->get('email'),
        );

        /**
         * @var ConstraintViolationList
         */
        $violations = $validator->validate($command);

        if (count($violations) != 0) {
            $errors = [];
            foreach ($violations as $violation) {
                $errors[] = [
                    'path'    => $violation->getPropertyPath(),
                    'message' => $violation->getMessage(),
                ];
            }

            return new JsonResponse(['errors' => $errors], 400);
        }

        /** @var HistoricalQuotesTask $task */
        $task = $commandBus->handle($command);

        return new JsonResponse(['task_uuid' => $task->getUuid()]);
    }
}