<?php declare(strict_types=1);

namespace App\Controller\Api\V1;

use App\Command\CreateHistoricalQuotesTaskCommand;
use App\Entity\HistoricalQuotesTask;
use App\QueryService\HistoricalQuotesTaskQueryInterface;
use League\Tactician\CommandBus;
use Ramsey\Uuid\Uuid;
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
     * @Route("/", methods={"POST"}, name="api_create_historical_quotes_task")
     *
     * @param Request $request
     * @param ValidatorInterface $validator
     * @param CommandBus $commandBus
     *
     * @return JsonResponse
     */
    public function createTask(Request $request, ValidatorInterface $validator, CommandBus $commandBus): JsonResponse
    {
        try {


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
        } catch (\RuntimeException $e) {
            return new JsonResponse(['errors' => [$e->getMessage()]], 400);

        }
        return new JsonResponse(['task_uuid' => $task->getUuid()]);
    }

    /**
     * @Route("/{uuid}/status", methods={"GET"}, name="api_get_historical_quotes_task_status")
     *
     * @param string $uuid
     * @param HistoricalQuotesTaskQueryInterface $historicalQuotesTaskQuery
     *
     * @return JsonResponse
     */
    public function getTaskStatus(string $uuid, HistoricalQuotesTaskQueryInterface $historicalQuotesTaskQuery): JsonResponse
    {
        $task = $historicalQuotesTaskQuery->query(Uuid::fromString($uuid));

        return new JsonResponse(
            [
                'is_retrieved_quotes' => null !== $task->getData(),
                'is_notified'         => $task->isNotified(),
            ]
        );
    }

    /**
     * @Route("/{uuid}", methods={"GET"}, name="api_get_historical_quotes_task_quotes")
     *
     * @param string $uuid
     * @param HistoricalQuotesTaskQueryInterface $historicalQuotesTaskQuery
     *
     * @return JsonResponse
     */
    public function getQuotes(string $uuid, HistoricalQuotesTaskQueryInterface $historicalQuotesTaskQuery): JsonResponse
    {
        $task = $historicalQuotesTaskQuery->query(Uuid::fromString($uuid));

        return new JsonResponse(
            $task->getData()
        );
    }
}
