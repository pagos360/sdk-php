<?php

namespace Pagos360\Repositories;

use Pagos360\Types;

class ResultRepository extends AbstractRepository
{
    const EDITABLE = false;
    const FIELDS = [
        'id' => [
            self::FLAG_READONLY => true,
            self::TYPE => Types::INT,
        ],
        'type' => [
            self::FLAG_READONLY => true,
            self::TYPE => Types::STRING,
        ],
        'channel' => [
            self::FLAG_READONLY => true,
            self::TYPE => Types::STRING,
            self::FLAG_MAYBE => true,
        ],
        'paidAt' => [
            self::FLAG_READONLY => true,
            self::TYPE => Types::DATETIME,
            self::FLAG_MAYBE => true,
            self::PROPERTY_PATH => 'paid_at',
        ],
        'createdAt' => [
            self::FLAG_READONLY => true,
            self::TYPE => Types::DATETIME,
            self::FLAG_MAYBE => true,
            self::PROPERTY_PATH => 'created_at',
        ],
        'availableAt' => [
            self::FLAG_READONLY => true,
            self::TYPE => Types::DATETIME,
            self::FLAG_MAYBE => true,
            self::PROPERTY_PATH => 'available_at',
        ],
        'isAvailable' => [
            self::FLAG_READONLY => true,
            self::TYPE => Types::BOOL,
            self::FLAG_MAYBE => true,
            self::PROPERTY_PATH => 'is_available',
        ],
        'amount' => [
            self::FLAG_READONLY => true,
            self::TYPE => Types::FLOAT,
            self::FLAG_MAYBE => true,
        ],
        'grossFee' => [
            self::FLAG_READONLY => true,
            self::TYPE => Types::FLOAT,
            self::FLAG_MAYBE => true,
            self::PROPERTY_PATH => 'gross_fee',
        ],
        'netFee' => [
            self::FLAG_READONLY => true,
            self::TYPE => Types::FLOAT,
            self::FLAG_MAYBE => true,
            self::PROPERTY_PATH => 'net_fee',
        ],
        'netAmount' => [
            self::FLAG_READONLY => true,
            self::TYPE => Types::FLOAT,
            self::FLAG_MAYBE => true,
            self::PROPERTY_PATH => 'net_amount',
        ],
        'feeIva' => [
            self::FLAG_READONLY => true,
            self::TYPE => Types::FLOAT,
            self::FLAG_MAYBE => true,
            self::PROPERTY_PATH => 'feeIva',
        ],
        'paymentMetadata' => [
            self::FLAG_READONLY => true,
            self::TYPE => Types::PAYMENT_METADATA,
            self::FLAG_MAYBE => true,
            self::PROPERTY_PATH => 'payment_metadata',
        ],
        'rejectedAt' => [
            self::FLAG_READONLY => true,
            self::TYPE => Types::DATETIME,
            self::FLAG_MAYBE => true,
            self::PROPERTY_PATH => 'rejected_at',
        ],
        'stateComment' => [
            self::FLAG_READONLY => true,
            self::TYPE => Types::STRING,
            self::FLAG_MAYBE => true,
            self::PROPERTY_PATH => 'state_comment',
        ],
        'revertedAt' => [
            self::FLAG_READONLY => true,
            self::TYPE => Types::DATETIME,
            self::FLAG_MAYBE => true,
            self::PROPERTY_PATH => 'reverted_at',
        ],
    ];
}
