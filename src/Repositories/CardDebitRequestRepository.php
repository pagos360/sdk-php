<?php

namespace Pagos360\Repositories;

use Pagos360\Constants;
use Pagos360\Exceptions\CardDebitRequests\CardDebitRequestNotPaidException;
use Pagos360\ModelFactory;
use Pagos360\Models\CardDebitRequest;
use Pagos360\Models\Result;
use Pagos360\Types;

class CardDebitRequestRepository extends AbstractRepository
{
    const MODEL = CardDebitRequest::class;
    const BLOCK_PREFIX = 'card_debit_request';
    const API_URI = 'card-debit-request';

    const EDITABLE = false;
    const FIELDS = [
        "id" => [
            self::PROPERTY_PATH => "id",
            self::TYPE => Types::INT,
            self::FLAG_READONLY => true,
        ],
        "type" => [
            self::PROPERTY_PATH => "type",
            self::TYPE => Types::STRING,
            self::FLAG_READONLY => true,
        ],
        "state" => [
            self::PROPERTY_PATH => "state",
            self::TYPE => Types::STRING,
            self::FLAG_READONLY => true,
        ],
        "createdAt" => [
            self::PROPERTY_PATH => "created_at",
            self::TYPE => Types::DATETIME,
            self::FLAG_READONLY => true,
        ],
        "amount" => [
            self::PROPERTY_PATH => "amount",
            self::TYPE => Types::FLOAT,
            self::FLAG_REQUIRED => true,
        ],
        "month" => [
            self::PROPERTY_PATH => "month",
            self::TYPE => Types::INT, // @todo Add MONTH type?
            self::FLAG_REQUIRED => true,
        ],
        "year" => [
            self::PROPERTY_PATH => "year",
            self::TYPE => Types::INT, // @todo Add YEAR type?
            self::FLAG_REQUIRED => true,
        ],
        "metadata" => [
            self::PROPERTY_PATH => "metadata",
            self::TYPE => Types::ARRAY, // @todo review
            self::FLAG_MAYBE => true,
        ],
        "description" => [
            self::PROPERTY_PATH => "description",
            self::TYPE => Types::STRING,
            self::FLAG_MAYBE => true,
        ],
        "cardAdhesion" => [
            self::PROPERTY_PATH => "card_adhesion",
            self::TYPE => Types::CARD_ADHESION,
            self::FLAG_REQUIRED => true,
        ],
        "results" => [
            self::PROPERTY_PATH => "request_result",
            self::TYPE => Types::RESULTS,
            self::FLAG_MAYBE => true,
            self::FLAG_READONLY => true,
        ],
    ];

    /**
     * @param int $id
     * @return CardDebitRequest
     */
    public function get(int $id): CardDebitRequest
    {
        $url = sprintf('%s/%s', self::API_URI, $id);
        $fromApi = $this->restClient->get($url);

        return ModelFactory::build(self::MODEL, $fromApi);
    }

    /**
     * @param CardDebitRequest $cardDebitRequest
     * @return bool
     */
    public function isPaid(CardDebitRequest $cardDebitRequest): bool
    {
        return $cardDebitRequest->getState() === Constants::CARD_DEBIT_REQUEST_PAID_STATE;
    }

    /**
     * @param CardDebitRequest $cardDebitRequest
     * @return CardDebitRequest
     * @throws CardDebitRequestNotPaidException
     */
    public function assertIsPaid(
        CardDebitRequest $cardDebitRequest
    ): CardDebitRequest {
        if (!$this->isPaid($cardDebitRequest)) {
            throw new CardDebitRequestNotPaidException($cardDebitRequest);
        }

        return $cardDebitRequest;
    }

    /**
     * @param CardDebitRequest $cardDebitRequest
     * @return CardDebitRequest
     */
    public function create(CardDebitRequest $cardDebitRequest)
    {
        $serialized = $this->buildBodyToSave(
            $cardDebitRequest,
            self::BLOCK_PREFIX,
            self::FIELDS
        );

        $fromApi = $this->restClient->post(self::API_URI, $serialized);

        return ModelFactory::build(self::MODEL, $fromApi);
    }

    /**
     * @param CardDebitRequest $cardDebitRequest
     * @return CardDebitRequest
     */
    public function cancel(CardDebitRequest $cardDebitRequest): CardDebitRequest
    {
        $serialized = [];
        $url = sprintf('%s/%s/cancel', self::API_URI, $cardDebitRequest->getId());
        $fromApi = $this->restClient->put($url, $serialized);

        /** @var CardDebitRequest $instantiated */
        $instantiated = ModelFactory::build(self::MODEL, $fromApi);
        return $instantiated;
    }

    /**
     * @param CardDebitRequest $debitRequest
     * @return Result|null
     */
    public function findCollectedResult(
        CardDebitRequest $debitRequest
    ): ?Result {
        foreach ($debitRequest->getResults() as $result) {
            /** @var Result $result */
            if ($result->getType() === 'collected_card_debit_request_result') {
                return $result;
            }
        }

        return null;
    }
}
