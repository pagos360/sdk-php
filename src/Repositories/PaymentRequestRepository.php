<?php

namespace Pagos360\Repositories;

use Pagos360\Constants;
use Pagos360\Exceptions\MissingRequiredInputException;
use Pagos360\Exceptions\PaymentRequests\PaymentRequestNotPaidException;
use Pagos360\Filters\PaymentRequestFilters;
use Pagos360\ModelFactory;
use Pagos360\Models\PaymentRequest;
use Pagos360\Models\Result;
use Pagos360\PaginatedResponse;
use Pagos360\Pagination;
use Pagos360\Types;

class PaymentRequestRepository extends AbstractRepository
{
    const MODEL = PaymentRequest::class;
    const BLOCK_PREFIX = 'payment_request';
    const API_URI = 'payment-request';
    const DEFAULT_ITEMS_PER_PAGE = 25;

    const EDITABLE = false;
    const FIELDS = [
        'id' => [
            self::FLAG_READONLY => true,
            self::TYPE => Types::INT,
        ],
        'state' => [
            self::FLAG_READONLY => true,
            self::TYPE => Types::STRING,
        ],
        "createdAt" => [
            self::FLAG_READONLY => true,
            self::TYPE => Types::DATETIME,
            self::PROPERTY_PATH => 'created_at',
        ],
        'description' => [
            self::FLAG_REQUIRED => true,
            self::TYPE => Types::STRING,
        ],
        'externalReference' => [
            self::TYPE => Types::STRING,
            self::PROPERTY_PATH => 'external_reference',
            self::FLAG_MAYBE => true,
        ],
        'firstDueDate' => [
            self::FLAG_REQUIRED => true,
            self::TYPE => Types::DATE,
            self::PROPERTY_PATH => 'first_due_date',
        ],
        'firstTotal' => [
            self::FLAG_REQUIRED => true,
            self::TYPE => Types::FLOAT,
            self::PROPERTY_PATH => 'first_total',
        ],
        'secondDueDate' => [
            self::TYPE => Types::DATE,
            self::PROPERTY_PATH => 'second_due_date',
        ],
        'secondTotal' => [
            self::TYPE => Types::FLOAT,
            self::PROPERTY_PATH => 'second_total',
        ],
        'payerName' => [
            self::FLAG_REQUIRED => true,
            self::TYPE => Types::STRING,
            self::PROPERTY_PATH => 'payer_name',
        ],
        'payerEmail' => [
            self::TYPE => Types::EMAIL,
            self::PROPERTY_PATH => 'payer_email',
        ],
        'metadata' => [
            self::TYPE => Types::ARRAY, // @todo review
            self::FLAG_MAYBE => true,
        ],
        'barcode' => [
            self::FLAG_READONLY => true,
            self::TYPE => Types::STRING,
        ],
        'checkoutUrl' => [
            self::FLAG_READONLY => true,
            self::TYPE => Types::URL,
            self::PROPERTY_PATH => 'checkout_url',
        ],
        'barcodeUrl' => [
            self::FLAG_READONLY => true,
            self::TYPE => Types::URL,
            self::PROPERTY_PATH => 'barcode_url',
        ],
        'pdfUrl' => [
            self::FLAG_READONLY => true,
            self::TYPE => Types::URL,
            self::PROPERTY_PATH => 'pdf_url',
        ],
        'backUrlSuccess' => [
            self::TYPE => Types::URL,
            self::PROPERTY_PATH => 'back_url_success',
        ],
        'backUrlPending' => [
            self::TYPE => Types::URL,
            self::PROPERTY_PATH => 'back_url_pending',
        ],
        'backUrlRejected' => [
            self::TYPE => Types::URL,
            self::PROPERTY_PATH => 'back_url_rejected',
        ],
        'excludedChannelTypes' => [
            self::TYPE => Types::ARRAY_OF_STRINGS,
            self::PROPERTY_PATH => 'excluded_channel_types',
        ],
        'holderData' => [
            self::FLAG_READONLY => true,
            self::TYPE => Types::HOLDER_DATA,
            self::FLAG_MAYBE => true,
            self::PROPERTY_PATH => 'holder_data',
        ],
        'results' => [
            self::FLAG_READONLY => true,
            self::TYPE => Types::RESULTS,
            self::PROPERTY_PATH => 'request_result',
        ],
    ];

    /**
     * @param int $id
     * @return PaymentRequest
     */
    public function get(int $id): PaymentRequest
    {
        $url = sprintf('%s/%s', self::API_URI, $id);
        $fromApi = $this->restClient->get($url);

        return ModelFactory::build(PaymentRequest::class, $fromApi);
    }

    /**
     * @param int $page
     * @param int $itemsPerPage
     * @return PaginatedResponse
     * @todo Abstract some of this?
     */
    public function getPage(
        int $page = 1,
        int $itemsPerPage = self::DEFAULT_ITEMS_PER_PAGE
    ): PaginatedResponse {
        $queryString = $this->buildPagedQueryString(
            $page,
            $itemsPerPage,
            null
        );
        $paginatedResponse = $this->restClient->get(
            self::API_URI,
            $queryString
        );

        $pagination = $this->getPaginationFromPaginatedResponse(
            $paginatedResponse
        );
        $data = $this->parseDatafromPaginatedResponse(
            self::MODEL,
            $paginatedResponse
        );

        return new PaginatedResponse($pagination, $data);
    }

    /**
     * @param PaymentRequestFilters|null $filters
     * @param int                        $page
     * @param int                        $itemsPerPage
     * @return PaginatedResponse
     * @todo Abstract some of this?
     */
    public function getFilteredPage(
        PaymentRequestFilters $filters = null,
        int $page = 1,
        int $itemsPerPage = self::DEFAULT_ITEMS_PER_PAGE
    ): PaginatedResponse {
        $queryString = $this->buildPagedQueryString(
            $page,
            $itemsPerPage,
            $filters
        );
        $paginatedResponse = $this->restClient->get(
            self::API_URI,
            $queryString
        );

        $pagination = $this->getPaginationFromPaginatedResponse(
            $paginatedResponse
        );
        $data = $this->parseDatafromPaginatedResponse(
            self::MODEL,
            $paginatedResponse
        );

        return new PaginatedResponse($pagination, $data);
    }

    /**
     * @param PaymentRequest $paymentRequest
     * @return PaymentRequest
     * @throws MissingRequiredInputException
     */
    public function create(PaymentRequest $paymentRequest)
    {
        $serialized = $this->buildBodyToSave(
            $paymentRequest,
            self::BLOCK_PREFIX,
            self::FIELDS
        );

        $fromApi = $this->restClient->post(self::API_URI, $serialized);

        return ModelFactory::build(PaymentRequest::class, $fromApi);
    }

    /**
     * @param PaymentRequest $paymentRequest
     * @return bool
     */
    public function isPaid(PaymentRequest $paymentRequest): bool
    {
        return $paymentRequest->getState() === Constants::PAYMENT_REQUEST_PAID_STATE;
    }

    /**
     * @param PaymentRequest $paymentRequest
     * @return PaymentRequest
     * @throws PaymentRequestNotPaidException
     */
    public function assertIsPaid(
        PaymentRequest $paymentRequest
    ): PaymentRequest {
        if (!$this->isPaid($paymentRequest)) {
            throw new PaymentRequestNotPaidException($paymentRequest);
        }

        return $paymentRequest;
    }

    /**
     * @param PaymentRequestFilters|null $filters
     * @return \Generator|PaymentRequest[]
     */
    public function listGenerator(
        ?PaymentRequestFilters $filters = null
    ): \Generator {
        $url = sprintf('%s', self::API_URI);
        $pagination = new Pagination(1, self::DEFAULT_ITEMS_PER_PAGE);

        do {
            $parsedFilters = $this->parseFilters($filters);
            $queryString = array_merge(
                $parsedFilters,
                $pagination->toQueryString()
            );
            $fromApi = $this->restClient->get($url, $queryString);

            foreach ($fromApi['data'] as $pr) {
                yield ModelFactory::build(PaymentRequest::class, $pr);
            }

            $pagination = $this->getPaginationFromPaginatedResponse($fromApi);
            $pagination->advancePage();
        } while ($pagination->hasMore());
    }

    /**
     * @param PaymentRequest $paymentRequest
     * @return Result|null
     */
    public function findCollectedResult(
        PaymentRequest $paymentRequest
    ): ?Result {
        foreach ($paymentRequest->getResults() as $result) {
            /** @var Result $result */
            if ($result->getType() === 'collected_payment_request_result') {
                return $result;
            }
        }

        return null;
    }
}
