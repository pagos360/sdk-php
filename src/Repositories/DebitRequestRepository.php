<?php

namespace Pagos360\Repositories;

use Pagos360\Constants;
use Pagos360\Exceptions\DebitRequests\DebitRequestNotPaidException;
use Pagos360\ModelFactory;
use Pagos360\Models\Adhesion;
use Pagos360\Models\DebitRequest;
use Pagos360\Models\Result;
use Pagos360\Types;

class DebitRequestRepository extends AbstractRepository
{
    const MODEL = DebitRequest::class;
    const BLOCK_PREFIX = 'debit_request';
    const API_URI = 'debit-request';

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
        'adhesion' => [
            self::FLAG_REQUIRED => true,
            self::TYPE => Types::ADHESION,
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
        'metadata' => [
            self::TYPE => Types::ARRAY, // @todo review
            self::FLAG_MAYBE => true,
        ],
        'results' => [
            self::FLAG_READONLY => true,
            self::TYPE => Types::RESULTS,
            self::PROPERTY_PATH => 'request_result',
        ],
    ];

    /**
     * @param int $id
     * @return DebitRequest
     */
    public function get(int $id): DebitRequest
    {
        $url = sprintf('%s/%s', self::API_URI, $id);
        $fromApi = $this->restClient->get($url);

        return ModelFactory::build(self::MODEL, $fromApi);
    }

    /**
     * @param DebitRequest $debitRequest
     * @return bool
     */
    public function isPaid(DebitRequest $debitRequest): bool
    {
        return $debitRequest->getState() === Constants::DEBIT_REQUEST_PAID_STATE;
    }

    /**
     * @param DebitRequest $debitRequest
     * @return DebitRequest
     * @throws DebitRequestNotPaidException
     */
    public function assertIsPaid(
        DebitRequest $debitRequest
    ): DebitRequest {
        if (!$this->isPaid($debitRequest)) {
            throw new DebitRequestNotPaidException($debitRequest);
        }

        return $debitRequest;
    }

    /**
     * @param DebitRequest $debitRequest
     * @return DebitRequest
     */
    public function create(DebitRequest $debitRequest)
    {
        $serialized = $this->buildBodyToSave(
            $debitRequest,
            self::BLOCK_PREFIX,
            self::FIELDS
        );

        $fromApi = $this->restClient->post(self::API_URI, $serialized);

        return ModelFactory::build(self::MODEL, $fromApi);
    }

    /**
     * @param DebitRequest $debitRequest
     * @return DebitRequest
     */
    public function cancel(DebitRequest $debitRequest): DebitRequest
    {
        $serialized = [];
        $url = sprintf('%s/%s/cancel', self::API_URI, $debitRequest->getId());
        $fromApi = $this->restClient->put($url, $serialized);

        /** @var DebitRequest $instantiated */
        $instantiated = ModelFactory::build(self::MODEL, $fromApi);
        return $instantiated;
    }

    /**
     * @param DebitRequest $debitRequest
     * @return Result|null
     */
    public function findCollectedResult(
        DebitRequest $debitRequest
    ): ?Result {
        foreach ($debitRequest->getResults() as $result) {
            /** @var Result $result */
            if ($result->getType() === 'collected_debit_request_result') {
                return $result;
            }
        }

        return null;
    }
}
