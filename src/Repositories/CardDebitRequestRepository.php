<?php

namespace Pagos360\Repositories;

use Pagos360\Models\CardDebitRequest;
use Pagos360\Types;

class CardDebitRequestRepository extends AbstractRepository
{
    const MODEL = CardDebitRequest::class;
    const BLOCK_PREFIX = 'payment_request';
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
    ];
}
