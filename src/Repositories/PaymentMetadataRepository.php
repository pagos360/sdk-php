<?php

namespace Pagos360\Repositories;

use Pagos360\Types;

class PaymentMetadataRepository extends AbstractRepository
{
    const EDITABLE = false;
    const FIELDS = [
        'holderName' => [
            self::TYPE => Types::STRING,
            self::FLAG_READONLY => true,
            self::PROPERTY_PATH => 'holder_name',
        ],
        'holderEmail' => [
            self::TYPE => Types::STRING,
            self::FLAG_READONLY => true,
            self::PROPERTY_PATH => 'holder_email',
        ],
        'authorizationCode' => [
            self::TYPE => Types::STRING,
            self::FLAG_READONLY => true,
            self::PROPERTY_PATH => 'authorization_code',
        ],
        'cardBrand' => [
            self::TYPE => Types::STRING,
            self::FLAG_READONLY => true,
            self::PROPERTY_PATH => 'card_brand',
        ],
        'cardLastFourDigits' => [
            self::TYPE => Types::STRING,
            self::FLAG_READONLY => true,
            self::PROPERTY_PATH => 'card_last_four_digits',
        ],
        'amount' => [
            self::TYPE => Types::FLOAT,
            self::FLAG_READONLY => true,
        ],
        'installments' => [
            self::TYPE => Types::INT,
            self::FLAG_READONLY => true,
        ],
        'installmentAmount' => [
            self::TYPE => Types::FLOAT,
            self::FLAG_READONLY => true,
            self::PROPERTY_PATH => 'installment_amount',
        ],
    ];
}
