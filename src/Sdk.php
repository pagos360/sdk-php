<?php

namespace Pagos360;

use GuzzleHttp\Client as GuzzleClient;
use GuzzleHttp\RequestOptions as GuzzleRequestOptions;
use Pagos360\Repositories\AccountRepository;
use Pagos360\Repositories\AdhesionRepository;
use Pagos360\Repositories\CardAdhesionRepository;
use Pagos360\Repositories\CardDebitRequestRepository;
use Pagos360\Repositories\ChargebackReportRepository;
use Pagos360\Repositories\CollectionReportRepository;
use Pagos360\Repositories\DebitRequestRepository;
use Pagos360\Repositories\PaymentRequestRepository;
use Pagos360\Repositories\SettlementReportRepository;
use Psr\Log\LoggerAwareInterface;
use Psr\Log\LoggerAwareTrait;
use Psr\Log\LoggerInterface;

class Sdk implements LoggerAwareInterface
{
    use LoggerAwareTrait;

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
     * @var CollectionReportRepository
     */
    public $collectionReports;

    /**
     * @var SettlementReportRepository
     */
    public $settlementReports;

    /**
     * @var ChargebackReportRepository
     */
    public $chargebackReports;

    /**
     * @var CardAdhesionRepository
     */
    public $cardAdhesions;

    /**
     * @var CardDebitRequestRepository
     */
    public $cardDebitRequests;

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
        $this->collectionReports = new CollectionReportRepository($this->restClient);
        $this->settlementReports = new SettlementReportRepository($this->restClient);
        $this->chargebackReports = new ChargebackReportRepository($this->restClient);
        $this->cardAdhesions = new CardAdhesionRepository($this->restClient);
        $this->cardDebitRequests = new CardDebitRequestRepository($this->restClient);
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
    public function setLoggerAndPropagate(LoggerInterface $logger)
    {
        $this->logger = $logger;
        $this->restClient->setLogger($logger);
        $this->paymentRequests->setLogger($logger);
        $this->debitRequests->setLogger($logger);
        $this->adhesions->setLogger($logger);
        $this->collectionReports->setLogger($logger);
        $this->settlementReports->setLogger($logger);
        $this->chargebackReports->setLogger($logger);
        $this->cardAdhesions->setLogger($logger);
        $this->cardDebitRequests->setLogger($logger);
    }
}
