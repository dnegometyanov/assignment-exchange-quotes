<?php declare(strict_types=1);

namespace App\Controller;

use App\Command\CreateHistoricalQuotesTaskCommand;
use App\Entity\HistoricalQuotesTask;
use App\Form\Type\HistoricalQuotesTaskType;
use League\Tactician\CommandBus;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\FormError;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response as Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Validator\ConstraintViolationInterface;
use Symfony\Component\Validator\ConstraintViolationList;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @Route("/task")
 */
class HistoricalQuotesTaskMonolithController extends AbstractController
{
    /**
     * @Route("/", methods={"GET", "POST"}, name="create_historical_quotes_task")
     *
     * @param Request $request
     * @param ValidatorInterface $validator
     * @param CommandBus $commandBus
     *
     * @return Response
     */
    public function create(Request $request, ValidatorInterface $validator, CommandBus $commandBus): Response
    {
        $form = $this->createForm(HistoricalQuotesTaskType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $formData = $form->getData();

            $command = new CreateHistoricalQuotesTaskCommand(
                $formData['listing']->getSymbol(),
                $formData['dateFrom']->format('Y-m-d'),
                $formData['dateTo']->format('Y-m-d'),
                $formData['email'],
            );

            /**
             * @var ConstraintViolationList
             */
            $violations = $validator->validate($command);

            if (count($violations) === 0) {

                /** @var HistoricalQuotesTask $task */
                $task = $commandBus->handle($command);

                return $this->redirectToRoute('view_historical_quotes_task', ['uuid' => $task->getUuid()]);
            }

            foreach ($violations as $violation) {
                /** @var ConstraintViolationInterface $violation */
                $form->get($violation->getPropertyPath())->addError(new FormError($violation->getMessage()));
            }
        }

        return $this->render('HistoricalQuotesTask/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{uuid}/view", methods={"GET"}, name="view_historical_quotes_task")
     *
     * @param string $uuid
     *
     * @return Response
     */
    public function view(string $uuid): Response
    {
        return $this->render('HistoricalQuotesTask/view.html.twig', [
            'uuid' => $uuid,
        ]);
    }
}
