<?php declare(strict_types=1);
namespace App\CommandHandler;

use App\Command\GetAndUpdateHistoricalQuotesCommand;
use App\Repository\HistoricalQuotesTaskRepositoryInterface;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class GetAndUpdateHistoricalQuotesCommandHandler
{
    const QUOTES_SERVICE_GET_HISTORICAL_QUOTES_URL = 'https://apidojo-yahoo-finance-v1.p.rapidapi.com/stock/v2/get-historical-data';
    const QUOTES_SERVICE_HEADER_X_RAPIDAPI_HOST    = 'apidojo-yahoo-finance-v1.p.rapidapi.com';

    /**
     * @var HistoricalQuotesTaskRepositoryInterface
     */
    private HistoricalQuotesTaskRepositoryInterface $taskRepository;

    /**
     * @var EntityManagerInterface
     */
    private EntityManagerInterface $em;

    /**
     * @var HttpClientInterface
     */
    private HttpClientInterface $httpClient;

    /**
     * @var string
     */
    private string $xRapidApiKey;

    public function __construct(
        HistoricalQuotesTaskRepositoryInterface $taskRepository,
        EntityManagerInterface $em,
        HttpClientInterface $httpClient,
        string $xRapidApiKey
    )
    {
        $this->taskRepository = $taskRepository;
        $this->em             = $em;
        $this->httpClient     = $httpClient;
        $this->xRapidApiKey   = $xRapidApiKey;
    }

    public function handle(GetAndUpdateHistoricalQuotesCommand $command)
    {
        $task = $this->taskRepository->find($command->getTaskUuid());

        $response = $this->httpClient->request(
            'GET',
            self::QUOTES_SERVICE_GET_HISTORICAL_QUOTES_URL,
            [
                'headers' => [
                    'x-rapidapi-host' => self::QUOTES_SERVICE_HEADER_X_RAPIDAPI_HOST,
                    'x-rapidapi-key'  => $this->xRapidApiKey,
                    'useQueryString'  => 'true',
                ],
                'query'   => [
                    'frequency' => '1d',
                    'filter'    => 'history',
                    'symbol'    => $command->getSymbol(),
                    'period1'   => (new \DateTime($command->getDateFrom()))->getTimestamp(),
                    'period2'   => (new \DateTime($command->getDateTo()))->getTimestamp(),
                ],
            ]
        );

        if ($response->getStatusCode() !== Response::HTTP_OK) {
            throw new BadRequestHttpException('Error while getting quoted from third party quotes service.');
        }

        $responseData = json_decode($response->getContent(), true);

        if (!isset($responseData['prices'])) {
            throw new BadRequestHttpException('Invalid data format from third party quotes service.');
        }

        $task->setData($responseData['prices']);

        $task->setIsNotified(true);

        $this->em->flush();

        return $task;
    }
}
