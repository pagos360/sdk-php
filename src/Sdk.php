<?php

namespace Pagos360;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\RequestOptions as GuzzleRequestOptions;
use Pagos360\Repositories\AccountRepository;
use Pagos360\Repositories\AdhesionRepository;
use Pagos360\Repositories\CollectedReportRepository;
use Pagos360\Repositories\DebitRequestRepository;
use Pagos360\Repositories\PaymentRequestRepository;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerInterface;

class Sdk implements LoggerAwareInterface
{
    const VERSION = '0.0.0';
    const BASE_URL = 'https://api.pagos360.com';

    /**
     * @var RestClient
     */
    private $restClient;

    /**
     * @var PaymentRequestRepository
     */
    public $paymentRequests;

    /**
     * @var DebitRequestRepository
     */
    public $debitRequests;

    /**
     * @var AdhesionRepository
     */
    public $adhesions;

    /**
     * @var AccountRepository
     */
    public $account;

    /**
     * @var CollectedReportRepository
     */
    public $collectedReports;

    /**
     * @var LoggerInterface|null
     */
    protected $logger;

    /**
     * @param string $apiKey
     */
    public function __construct(string $apiKey)
    {
        $this->restClient = new RestClient(
            new GuzzleClient([
                'base_uri' => self::BASE_URL,
                'exceptions' => false,
                GuzzleRequestOptions::ALLOW_REDIRECTS => false,
                GuzzleRequestOptions::CONNECT_TIMEOUT => 30,
                GuzzleRequestOptions::HEADERS => [
                    'User-Agent' => 'Pagos360.com-SDK-PHP/' . self::VERSION,
                    'Content-Type' => 'application/json',
                ],
            ]),
            $apiKey
        );

        $this->paymentRequests = new PaymentRequestRepository($this->restClient);
        $this->debitRequests = new DebitRequestRepository($this->restClient);
        $this->adhesions = new AdhesionRepository($this->restClient);
        $this->account = new AccountRepository($this->restClient);
        $this->collectedReports = new CollectedReportRepository($this->restClient);
    }

    /**
     * @return RestClient
     */
    public function getRestClient(): RestClient
    {
        return $this->restClient;
    }

    /**
     * @return bool
     */
    public function ping()
    {
        $url = sprintf('%s/status', self::BASE_URL);
        $this->restClient->get($url);
        return true;
    }

    /**
     * @param LoggerInterface $logger
     */
    public function setLogger(LoggerInterface $logger)
    {
        $this->logger = $logger;
        $this->restClient->setLogger($logger);
        $this->paymentRequests->setLogger($logger);
        $this->debitRequests->setLogger($logger);
        $this->adhesions->setLogger($logger);
    }
}
